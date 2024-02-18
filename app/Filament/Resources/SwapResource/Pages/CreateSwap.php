<?php

namespace App\Filament\Resources\SwapResource\Pages;

use App\Filament\Resources\SwapResource;
use App\Models\Financial;
use App\Models\Movement;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Swap;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

use function PHPUnit\Framework\isNull;

class CreateSwap extends CreateRecord
{
    protected static string $resource = SwapResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // $data['green_coin'] = ($data['pet_bottles'] + $data['packaging_of_cleaning_materials'] + $data['tetra_pak'] + $data['aluminum_cans']) / 10;

    //     // dd($data);
    //     // return $data;

    //     $student = Student::all()->where('id', $data['student_id'])->first();
    //     $schoolClass = SchoolClass::all()->where('id', $student->school_class_id)->first();
    //     $school = School::all()->where('id', $schoolClass->school_id)->first();

    //     $financial = Financial::all()->where('school_id', $school->id)->first();

    //     if ($financial->balance < $data['green_coin']) {
    //         return [];
    //     }

    //     return $data;
    // }

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data = $this->form->getState();
    //     $data['pet_bottles'] = !isNull($data['pet_bottles']) ? $data['pet_bottles'] : 0;
    //     $data['packaging_of_cleaning_materials'] = !isNull($data['packaging_of_cleaning_materials']) ? $data['packaging_of_cleaning_materials'] : 0;
    //     $data['tetra_pak'] = !isNull($data['tetra_pak']) ? $data['tetra_pak'] : 0;
    //     $data['aluminum_cans'] = !isNull($data['aluminum_cans']) ? $data['aluminum_cans'] : 0;
    //     $data['total'] = !isNull($data['total']) ? $data['total'] : 0;
    //     $data['green_coin'] = !isNull($data['green_coin']) ? $data['green_coin'] : 0;

    //     return $data;
    // }

    // protected function beforeCreate(): void
    // {
    //     // Runs before the form fields are saved to the database.

    //     $data = $this->form->getState();

    //     $data['pet_bottles'] = $data['pet_bottles'] ? intval($data['pet_bottles']) : 0;
    //     $data['packaging_of_cleaning_materials'] = $data['packaging_of_cleaning_materials'] ? intval($data['packaging_of_cleaning_materials']) : 0;
    //     $data['tetra_pak'] = $data['tetra_pak'] ? intval($data['tetra_pak']) : 0;
    //     $data['aluminum_cans'] = $data['aluminum_cans'] ? intval($data['aluminum_cans']) : 0;
    //     $data['total'] = $data['total'] ? intval($data['total']) : 0;
    //     $data['green_coin'] = $data['green_coin'] ? intval($data['green_coin']) : 0;

    //     $student = Student::all()->where('id', $data['student_id'])->first();
    //     $school = $student->school_class->school;

    //     if ($data['total'] = 0) {
    //         Notification::make()
    //             ->warning()
    //             ->title('Recicláveis não informado!')
    //             ->body('Informe pelo menos um reciclável a ser trocado!')
    //             ->persistent()
    //             // ->actions([
    //             //     // Action::make('subscribe')
    //             //     //     ->button()
    //             //     //     ->url(route('subscribe'), shouldOpenInNewTab: true),
    //             // ])
    //             ->send();

    //         $this->halt();
    //     }

    //     if ($data['total'] > $school['limit_per_swap']) {
    //         Notification::make()
    //             ->warning()
    //             ->title('O limite de troca para esta escola é de ' . $school['limit_per_swap'] . ' recicláveis!')
    //             ->body('Diminua o numero de itens trocados!')
    //             ->persistent()
    //             ->actions([
    //                 // Action::make('subscribe')
    //                 //     ->button()
    //                 //     ->url(route('subscribe'), shouldOpenInNewTab: true),
    //             ])
    //             ->send();

    //         $this->halt();
    //     }
    // }

    public function create(bool $another = false): void
    {
        $this->authorizeAccess();

        try {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeCreate($data);

            $student = Student::all()->where('id', $data['student_id'])->first();
            $school = $student->school_class->school;

            // dd($data);

            if ($data['total'] == null) {
                Notification::make()
                    ->warning()
                    ->title('Recicláveis não informados!')
                    ->body('Informe pelo menos um reciclável a ser trocado!')
                    ->persistent()
                    ->actions([
                        //     // Action::make('subscribe')->button()->url(route('subscribe'), shouldOpenInNewTab: true),
                    ])
                    ->send();

                $this->halt();
            }

            if (intval($data['total']) > intval($school['limit_per_swap'])) {
                Notification::make()
                    ->warning()
                    ->title('O limite de troca para esta escola é de ' . $school['limit_per_swap'] . ' recicláveis!')
                    ->body('Diminua o numero de itens trocados!')
                    ->persistent()
                    ->actions([
                        // Action::make('subscribe')->button()->url(route('subscribe'), shouldOpenInNewTab: true),
                    ])
                    ->send();

                $this->halt();
            }

            $this->callHook('beforeCreate');

            $this->record = $this->handleRecordCreation($data);

            $this->form->model($this->record)->saveRelationships();

            $this->callHook('afterCreate');

            /**
             *
             */
            $student = Student::all()->where('id', $data['student_id'])->first();
            $schoolClass = SchoolClass::all()->where('id', $student->school_class_id)->first();
            $school = School::all()->where('id', $schoolClass->school_id)->first();

            $financial = Financial::all()->where('school_id', $school->id)->first();

            $movement = Movement::create([
                'financial_id' => $financial->id,
                'student_id' => $student->id,
                'date' => now(),
                'status' => 'output',
                'value' => $this->record->green_coin
            ]);

            $financial->balance = ($financial->balance - $movement->value);
            $financial->save();
        } catch (Halt $exception) {
            return;
        }

        $this->getCreatedNotification()?->send();

        if ($another) {
            // Ensure that the form record is anonymized so that relationships aren't loaded.
            $this->form->model($this->record::class);
            $this->record = null;

            $this->fillForm();

            return;
        }

        $this->redirect($this->getRedirectUrl());
    }
}
