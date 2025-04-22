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

                <!-- 和暦入力 -->
                <div id="warekiInput" class="space-y-2">
                    <label class="block font-semibold text-gray-700">和暦:</label>
                    <div class="flex flex-wrap gap-2">
                        <!-- 元号 -->
                        <div class="flex-1 min-w-[40%] relative">
                            <select id="era" name="era"
                                class="w-full border border-gray-300 rounded-md bg-white pr-10 pl-3 py-2 shadow-sm appearance-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- 選択 --</option>
                                <option value="reiwa">令和</option>
                                <option value="heisei">平成</option>
                                <option value="showa">昭和</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <!-- 年 -->
                        <div class="flex-1 min-w-[40%] relative">
                            <select id="warekiYear" name="warekiYear"
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
        document.addEventListener('DOMContentLoaded', function() {
            const seirekiYear = document.getElementById('seirekiYear');
            const era = document.getElementById('era');
            const warekiYear = document.getElementById('warekiYear');
            const month = document.getElementById('month');
            const day = document.getElementById('day');
            const currentYear = new Date().getFullYear();
            const minSeireki = 1900;
            const maxSeireki = currentYear - 40; // ← 年齢制限があるならこれも使用

            seirekiYear.innerHTML = `<option value="">-- 選択 --</option>`;
            for (let y = minSeireki; y <= currentYear; y++) {
                if (y > maxSeireki) {
                    seirekiYear.innerHTML += `<option value="${y}">${y}</option>`;
                }
            }

            warekiYear.innerHTML = `<option value="">-- 選択 --</option>`;
            for (let y = 1; y <= 99; y++) {
                warekiYear.innerHTML += `<option value="${y}">${y}</option>`;
            }

            month.innerHTML = `<option value="">-- 選択 --</option>`;
            for (let m = 1; m <= 12; m++) {
                month.innerHTML += `<option value="${m}">${m}</option>`;
            }

            day.innerHTML = `<option value="">-- 選択 --</option>`;
            for (let d = 1; d <= 31; d++) {
                day.innerHTML += `<option value="${d}">${d}</option>`;
            }

            const resetButton = document.getElementById('resetButton');

            resetButton.addEventListener('click', () => {
                // 値をリセット
                seirekiYear.value = "";
                warekiYear.value = "";
                era.value = "";
                month.value = "";
                day.value = "";

                // disabled を解除（←これが抜けていた）
                seirekiYear.disabled = false;
                warekiYear.disabled = false;
                era.disabled = false;

                // グレーアウト解除（見た目）
                [seirekiYear, warekiYear, era].forEach(el => {
                    el.classList.remove('opacity-50', 'pointer-events-none', 'cursor-not-allowed');
                    el.classList.add('bg-white');
                });

                // 表示クリア
                document.getElementById('result').innerText = '';
                document.getElementById('milestoneResults').innerText = '';

                // 再評価
                updateInputState();
            });



            // 初期状態で 18歳（今日 - 18年）になるように設定
            (function setInitial18YearsOld() {
                const today = new Date();
                const birthDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

                // 和暦変換ロジック
                const eraStartYears = {
                    reiwa: 2019,
                    heisei: 1989,
                    showa: 1926
                };

                let eraKey = '';
                let warekiYearVal = 1;

                // 元号の決定
                if (birthDate.getFullYear() >= 2019) {
                    eraKey = 'reiwa';
                    warekiYearVal = birthDate.getFullYear() - 2019 + 1;
                } else if (birthDate.getFullYear() >= 1989) {
                    eraKey = 'heisei';
                    warekiYearVal = birthDate.getFullYear() - 1989 + 1;
                } else {
                    eraKey = 'showa';
                    warekiYearVal = birthDate.getFullYear() - 1926 + 1;
                }

                // 和暦をセット
                era.value = eraKey;
                era.dispatchEvent(new Event('change')); // 和暦年を生成させる

                // 少し待ってから和暦年をセット（dispatchEvent後の描画タイミング考慮）
                setTimeout(() => {
                    warekiYear.value = warekiYearVal.toString();
                    month.value = (birthDate.getMonth() + 1).toString();
                    day.value = birthDate.getDate().toString();

                    // 西暦は未使用＆無効化
                    seirekiYear.value = "";
                    seirekiYear.disabled = true;

                    // 和暦側有効化（念のため）
                    warekiYear.disabled = false;
                    era.disabled = false;

                    // 計算＆表示
                    updateInputState();
                    calculateAge();
                }, 10);
            })();



            function convertWarekiToSeireki(era, year) {
                const eraStartYears = {
                    reiwa: 2019,
                    heisei: 1989,
                    showa: 1926
                };
                return eraStartYears[era] + year - 1;
            }

            function calculateAge() {
                let year = null;
                const monthVal = parseInt(month.value);
                const dayVal = parseInt(day.value);

                if (!seirekiYear.disabled && seirekiYear.value) {
                    year = parseInt(seirekiYear.value);
                } else if (!warekiYear.disabled && warekiYear.value) {
                    year = convertWarekiToSeireki(era.value, parseInt(warekiYear.value));
                }

                if (isNaN(year) || isNaN(monthVal) || isNaN(dayVal)) {
                    document.getElementById('result').innerText = 'すべての項目を入力してください。';
                    document.getElementById('milestoneResults').innerText = '';
                    return;
                }

                if (!warekiYear.disabled && warekiYear.value && era.value) {
                    year = convertWarekiToSeireki(era.value, parseInt(warekiYear.value));
                }


                const birthDate = new Date(year, monthVal - 1, dayVal);
                const today = new Date();

                let age = today.getFullYear() - birthDate.getFullYear();
                const m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                document.getElementById('result').innerText = '現在の満年齢: ' + age + '歳';

                // milestone 計算
                const milestones = [21, 26, 30, 35];
                const milestoneTexts = [];

                if (age < 35) {
                    milestones.forEach(targetAge => {
                        if (age < targetAge) {
                            const targetDate = new Date(birthDate.getFullYear() + targetAge, birthDate.getMonth(), birthDate.getDate());
                            const diffTime = targetDate - today;

                            if (diffTime > 0) {
                                const diffDate = new Date(diffTime);
                                const y = diffDate.getUTCFullYear() - 1970;
                                const mo = diffDate.getUTCMonth();
                                const d = diffDate.getUTCDate() - 1;
                                milestoneTexts.push(`${targetAge}歳まで: ${y}年${mo}ヶ月${d}日`);
                            }
                        }
                    });
                }

                document.getElementById('milestoneResults').innerHTML = milestoneTexts.join('<br>');
            }

            function updateInputState() {
                const elements = [seirekiYear, warekiYear, era];
                elements.forEach(el => el.classList.remove('bg-gray-200', 'opacity-50', 'pointer-events-none', 'cursor-not-allowed'));

                if (seirekiYear.value) {
                    // 和暦側をグレーアウト
                    warekiYear.classList.add('opacity-50', 'pointer-events-none', 'cursor-not-allowed');
                    era.classList.add('opacity-50', 'pointer-events-none', 'cursor-not-allowed');
                } else if (warekiYear.value && era.value) {
                    // 西暦側をグレーアウト
                    seirekiYear.classList.add('opacity-50', 'pointer-events-none', 'cursor-not-allowed');
                }
            }


            // イベント登録
            [seirekiYear, warekiYear, era, month, day].forEach(el => {
                el.addEventListener('input', () => {
                    updateInputState();
                    calculateAge();
                });
            });

            // 数字入力欄には change イベントも追加
            day.addEventListener('change', () => {
                updateInputState();
                calculateAge();
            });

            // 初回実行
            updateInputState();
            calculateAge();
        });


        document.addEventListener('DOMContentLoaded', function() {
            const seirekiYear = document.getElementById('seirekiYear');
            const warekiYear = document.getElementById('warekiYear');
            const era = document.getElementById('era');

            const today = new Date();
            const minSeireki = 1900;
            const maxSeireki = today.getFullYear() - 40; // ← 40歳以上を除外

            // 西暦年の選択肢生成（1900〜40歳未満の年）
            seirekiYear.innerHTML = `<option value="">-- 選択 --</option>`;
            for (let y = minSeireki; y <= today.getFullYear(); y++) {
                if (y > maxSeireki) {
                    seirekiYear.innerHTML += `<option value="${y}">${y}</option>`;
                }
            }

            // 和暦（元号 + 年）の選択肢生成
            warekiYear.innerHTML = `<option value="">-- 選択 --</option>`;
            era.addEventListener('change', function() {
                const selectedEra = era.value;
                const eraStartYears = {
                    reiwa: 2019,
                    heisei: 1989,
                    showa: 1926
                };

                warekiYear.innerHTML = `<option value="">-- 選択 --</option>`;

                if (!selectedEra) return;

                const startYear = eraStartYears[selectedEra];
                const currentYear = today.getFullYear();
                const endYear = currentYear;
                const maxAllowed = currentYear - 40;

                for (let i = 1; i <= 99; i++) {
                    const seireki = startYear + i - 1;
                    if (seireki > maxAllowed) {
                        warekiYear.innerHTML += `<option value="${i}">${i}</option>`;
                    }
                }
            });

            // era初期化時に一度発火しておく（必要なら）
            era.dispatchEvent(new Event('change'));
        });


        document.getElementById('copyButton').addEventListener('click', function() {
            const resultText = document.getElementById('result').innerText;
            const milestoneText = document.getElementById('milestoneResults').innerText;
            const combinedText = `${resultText}\n${milestoneText}`.trim();

            if (combinedText) {
                navigator.clipboard.writeText(combinedText).then(() => {
                    alert('コピーしました！');
                }).catch(err => {
                    alert('コピーに失敗しました。');
                });
            } else {
                alert('コピーする内容がありません。');
            }
        });
    </script>



</x-app-layout>