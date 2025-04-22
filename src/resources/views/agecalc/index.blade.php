<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            年齢計算機
        </h2>
    </x-slot>

    <div class="bg-gray-100 flex justify-center pt-8 px-4">
        <div class="bg-white rounded-2xl shadow-sm p-8 w-full max-w-md mt-4">


            <h3 class="text-center text-lg font-bold mb-4">自動車保険用の年齢計算機です。</h3>
            <form id="ageCalculatorForm" class="space-y-4">

                <!-- 西暦入力 -->
                <div id="seirekiInput" class="space-y-2">
                    <label for="seirekiYear" class="block font-semibold text-gray-700">西暦:</label>
                    <div class="relative">
                        <select id="seirekiYear" name="seirekiYear"
                            class="w-full border border-gray-400 rounded-md bg-white pr-10 pl-3 py-2 shadow-sm appearance-none focus:ring-blue-500 focus:border-blue-500">
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                </div>

                <!-- 月＋日 横並び -->
                <div class="space-y-2">
                    <label class="block font-semibold text-gray-700">月日:</label>
                    <div class="flex gap-2">
                        <!-- 月 -->
                        <div class="flex-1 relative">
                            <select id="month" name="month"
                                class="w-full border border-gray-300 rounded-md bg-white pr-10 pl-3 py-2 shadow-sm appearance-none focus:ring-blue-500 focus:border-blue-500">
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <!-- 日 -->
                        <div class="flex-1 relative">
                            <select id="day" name="day"
                                class="w-full border border-gray-300 rounded-md bg-white pr-10 pl-3 py-2 shadow-sm appearance-none focus:ring-blue-500 focus:border-blue-500">
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>



            </form>

            <!-- リセットボタン -->
            <div class=" pt-4 text-right">
                <button id="resetButton" type="button"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                    リセット
                </button>
            </div>


            <div id="result" class="mt-6 text-blue-700 font-medium"></div>
            <div id="milestoneResults" class="mt-2 text-sm text-gray-700 space-y-1"></div>
            <div class="pt-4 text-right">
                <button id="copyButton" type="button"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                    コピー
                </button>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const seirekiYear = document.getElementById("seirekiYear");
            const month = document.getElementById("month");
            const day = document.getElementById("day");
            const result = document.getElementById("result");

            // 年を動的に生成（現在の年 - 18歳が初期値）
            const currentYear = new Date().getFullYear();
            for (let y = currentYear - 1; y >= currentYear - 100; y--) {
                const option = document.createElement("option");
                option.value = y;
                option.textContent = y + "年";
                seirekiYear.appendChild(option);
            }
            seirekiYear.value = currentYear - 18;

            // 月を生成
            for (let m = 1; m <= 12; m++) {
                const option = document.createElement("option");
                option.value = m;
                option.textContent = m + "月";
                month.appendChild(option);
            }
            month.value = 1;

            // 日を生成（選択された月に応じて日数を変更）
            function populateDays() {
                day.innerHTML = "";
                const selectedYear = parseInt(seirekiYear.value);
                const selectedMonth = parseInt(month.value);
                const daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();

                for (let d = 1; d <= daysInMonth; d++) {
                    const option = document.createElement("option");
                    option.value = d;
                    option.textContent = d + "日";
                    day.appendChild(option);
                }
                day.value = 1;
            }

            populateDays(); // 初期表示

            month.addEventListener("change", populateDays);
            seirekiYear.addEventListener("change", populateDays);

            // 年齢計算関数
            function calculateAge() {
                const birthYear = parseInt(seirekiYear.value);
                const birthMonth = parseInt(month.value);
                const birthDay = parseInt(day.value);

                const today = new Date();
                const birthDate = new Date(birthYear, birthMonth - 1, birthDay);

                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                const dayDiff = today.getDate() - birthDate.getDate();

                if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                    age--;
                }

                result.textContent = `満年齢：${age}歳`;
            }

            // イベントリスナーでリアルタイムに更新
            seirekiYear.addEventListener("change", calculateAge);
            month.addEventListener("change", calculateAge);
            day.addEventListener("change", calculateAge);

            // 初期計算
            calculateAge();

            // リセットボタン処理
            document.getElementById("resetButton").addEventListener("click", () => {
                seirekiYear.value = currentYear - 18;
                month.value = 1;
                populateDays();
                calculateAge();
            });
        });


        function getWareki(year) {
            if (year >= 2019) return `令和${year - 2018}年`;
            if (year >= 1989) return `平成${year - 1988}年`;
            if (year >= 1926) return `昭和${year - 1925}年`;
            if (year >= 1912) return `大正${year - 1911}年`;
            if (year >= 1868) return `明治${year - 1867}年`;
            return '';
        }

        const currentYear = new Date().getFullYear();
        const minYear = currentYear - 40; // 満年齢40歳以上を除外

        const seirekiYear = document.getElementById("seirekiYear");
        seirekiYear.innerHTML = ''; // 念のため初期化

        for (let y = currentYear - 1; y >= minYear; y--) {
            const option = document.createElement("option");
            const wareki = getWareki(y);
            option.value = y;
            option.textContent = `${y}（${wareki}）`;
            seirekiYear.appendChild(option);
        }

        seirekiYear.value = currentYear - 18; // 初期値：18歳
    </script>



</x-app-layout>