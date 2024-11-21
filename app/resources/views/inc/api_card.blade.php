<div href="#" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
    <div>
        <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{$title}}</h2>
        @foreach($endpoints as $endpoint)
            <h2 class="mt-6 text-l font-semibold text-gray-900 dark:text-white">{{$endpoint}}</h2>
        @endforeach
    </div>
</div>