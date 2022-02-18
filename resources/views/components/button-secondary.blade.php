<{{ isset($href) ? 'a' : 'button' }} {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 outline-gray-800 dark:outline-gray-100 border border-transparent rounded-md font-semibold text-xs text-dark dark:text-white uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-900 active:outline-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</{{ isset($href) ? 'a' : 'button' }}>
