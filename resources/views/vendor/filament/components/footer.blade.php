{{ \Filament\Facades\Filament::renderHook('footer.before') }}

<!-- <div class="filament-footer flex items-center justify-center"> -->
{{ \Filament\Facades\Filament::renderHook('footer.start') }}

@if (config('filament.layout.footer.should_show_logo'))
<!-- <footer class="-fixed bottom-4 -z-20 w-full p-4 pb-0 bg-white border-t border-gray-200 shadow md:flex md:items-center md:justify-between md:p-6 dark:bg-gray-800 dark:border-gray-600">
        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024
            <a href="https://br.linkedin.com/in/capital-consultoria-e-treinamentos-8b0a4445" target="_blank" class="hover:underline">Capital Consultoria e Treinamentos</a>. Produto registrado. Todos os direitos autoriais reservados.
        </span>
    </footer> -->

<!-- <a href="#" target="_blank" rel="noopener noreferrer" class="text-gray-300 transition hover:text-primary-500">
        <img src="{{ asset('logo-capital.png') }}" class="flex items-center justify-center">
        Produto registrado. Todos os direitos autoriais reservados.
    </a> -->

<div class="mx-auto mt-12 max-w-max w-full  ">
    <div class="bg-white rounded-lg shadow-md p-6 dark:bg-gray-800 dark:border-gray-600">
        <div class="flex items-center justify-center gap-6">
            <img class="w-1/3" src="{{ asset('logo-capital.png') }}" alt="">
            <div class="w-2/3">
                <h4 class="text-lg font-semibold">Produto Registrado</h4>
                <p class="text-gray-600">Proibida a reprodução sem a devida autorização.</p>
            </div>
        </div>
    </div>
</div>
@endif

{{ \Filament\Facades\Filament::renderHook('footer.end') }}
<!-- </div> -->

{{ \Filament\Facades\Filament::renderHook('footer.after') }}