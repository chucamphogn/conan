<button
    class="flex flex-row items-center py-2 px-4 mt-2 w-full font-semibold text-left bg-transparent rounded-lg transition duration-500 ease-in-out dark:bg-transparent dark:focus:text-white dark:hover:text-white dark:focus:bg-gray-600 dark:hover:bg-gray-600 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
    {{ $slot }}
    <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}"
         class="inline mt-1 ml-1 w-4 h-4 transition-transform duration-200 transform md:-mt-1">
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path>
    </svg>
</button>
