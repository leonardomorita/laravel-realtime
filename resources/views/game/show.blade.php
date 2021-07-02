<x-app-layout>
    <x-slot name="customStyles">
        <style>
            @keyframes rotate {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            .refresh {
                animation: rotate 1.5s linear infinite;
            }
        </style>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Game') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center flex justify-center">
                        <img src="{{ asset('images/circle.png') }}" alt="Circle" id="circle" height="250" width="250">
                        <p id="winner" class="hidden"></p>
                    </div>

                    <hr class="mt-1">

                    <div class="text-center">
                        <div class="p-2">
                            <label for="" class="">Your beat</label>
                            <select name="" id="bet">
                                <option selected>Not in</option>
                                @foreach (range(1, 12) as $number)
                                    <option>{{ $number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>

                        <div class="p-2">
                            <p class="font-bold text-lg">Remaining Time</p>
                            <p id="timer" class="text-red-500">Waiting to Start</p>
                        </div>

                        <hr>

                        <p id="result" class="p2"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            const circleElement = document.getElementById('circle');
            const timerElement = document.getElementById('timer');
            const winnerElement = document.getElementById('winner');
            const betElement = document.getElementById('bet');
            const resultElement = document.getElementById('result');

            Echo.channel('game')
                .listen('RemainingTimeChanged', (e) => {
                    timerElement.innerText = e.time;

                    circleElement.classList.add('refresh');

                    winnerElement.classList.add('hidden');

                    resultElement.innerText = '';
                    resultElement.classList.remove('text-green-500');
                    resultElement.classList.remove('text-red-500');
                })
                .listen('WinnerNumberGenerated', (e) => {
                    circleElement.classList.remove('refresh');
                    winnerElement.classList.remove('hidden');

                    let winnerNumber = e.number;
                    winnerElement.innerText = winnerNumber;
                    winnerElement.classList.remove('hidden');

                    const bet = betElement[betElement.selectedIndex].innerText
                    if (bet == winnerNumber) {
                        resultElement.innerText = 'You win';
                        resultElement.classList.add('text-green-500');
                    } else {
                        resultElement.innerText = `Sorry, the winner number is ${winnerNumber}`;
                        resultElement.classList.add('text-red-500');
                    }
                });
        </script>
    </x-slot>
</x-app-layout>
