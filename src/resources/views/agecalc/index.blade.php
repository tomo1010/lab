<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('agecalc.index') }}">
                    自動車保険用の年齢計算機
                </a>
            </h2>
            <x-head-buttons />
        </div>
    </x-slot>

    <div class="py-12 flex justify-center">
        <div class="w-full max-w-full md:max-w-4xl mx-auto p-6 bg-white rounded shadow space-y-8">
            <form id="ageCalculatorForm" class="space-y-4 max-w-md mx-auto">
                <!-- 西暦入力 -->
                <div id="seirekiInput" class="space-y-2">
                    <label for="seirekiYear" class="block font-semibold text-gray-700">年:</label>
                    <div class="relative">
                        <select id="seirekiYear" name="seirekiYear"
                                class="w-full border rounded bg-white pr-10 pl-3 py-2 shadow-sm appearance-none focus:ring-blue-500 focus:border-blue-500">
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
                                    class="w-full border border rounded bg-white pr-10 pl-3 py-2 shadow-sm appearance-none focus:ring-blue-500 focus:border-blue-500">
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
                                    class="w-full border rounded bg-white pr-10 pl-3 py-2 shadow-sm appearance-none focus:ring-blue-500 focus:border-blue-500">
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
            <div class=" pt-4 text-right max-w-md mx-auto">
                <button id="resetButton" type="button"
                        class="bg-green-600 hover:bg-green-700 px-4 py-2 text-white rounded-md transition">
                    リセット
                </button>
            </div>


            <div id="result" class="mt-6 text-blue-700 font-medium flex justify-center"></div>
            <div id="milestoneResults" class="mt-2 text-sm text-gray-700 space-y-1 flex justify-center"></div>
            <div class="pt-4 text-right max-w-md mx-auto">
                <button id="copyButton" type="button"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
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

            // 満年齢40歳未満のみ表示
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

            // 西暦の選択肢を生成
            seirekiYear.innerHTML = '';
            for (let y = currentYear - 1; y >= minYear; y--) {
                const option = document.createElement("option");
                const wareki = getWareki(y);
                option.value = y;
                option.textContent = `${y}（${wareki}）`;
                seirekiYear.appendChild(option);
            }

            seirekiYear.value = currentYear - 18;

            // 月の選択肢
            for (let m = 1; m <= 12; m++) {
                const option = document.createElement("option");
                option.value = m;
                option.textContent = m + "月";
                month.appendChild(option);
            }
            month.value = 1;

            // 日を生成
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

            populateDays();

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

                // 残り年数表示用ターゲット年齢
                const milestones = [21, 26, 30, 35];
                let output = "";

                milestones.forEach(targetAge => {
                    if (age < targetAge) {
                        const targetDate = new Date(birthDate);
                        targetDate.setFullYear(birthDate.getFullYear() + targetAge);

                        let remainingYears = targetDate.getFullYear() - today.getFullYear();
                        let remainingMonths = targetDate.getMonth() - today.getMonth();

                        if (remainingMonths < 0) {
                            remainingYears--;
                            remainingMonths += 12;
                        }

                        output += `${targetAge}歳まで：あと ${remainingYears}年 ${remainingMonths}ヶ月\n`;
                    }
                });

                milestoneResults.innerHTML = output.trim().replace(/\n/g, "<br>");
            }



            seirekiYear.addEventListener("change", calculateAge);
            month.addEventListener("change", calculateAge);
            day.addEventListener("change", calculateAge);

            calculateAge();

            document.getElementById("resetButton").addEventListener("click", () => {
                seirekiYear.value = currentYear - 18;
                month.value = 1;
                populateDays();
                calculateAge();
            });
        });
    </script>



</x-app-layout>