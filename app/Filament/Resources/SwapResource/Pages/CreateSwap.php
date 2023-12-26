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

    public function create(bool $another = false): void
    {
        $this->authorizeAccess();

        try {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeCreate($data);

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
