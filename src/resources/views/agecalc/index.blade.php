<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            年齢計算機
        </h2>
    </x-slot>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="min-h-screen bg-gray-100 flex items-center justify-center py-8">
        <div class="bg-white rounded-2xl shadow-md p-8 w-full max-w-md">
            <form id="ageCalculatorForm" class="space-y-4">
                <!-- 西暦入力 -->
                <div id="seirekiInput" class="space-y-2">
                    <label for="seirekiYear" class="block font-semibold text-gray-700">西暦:</label>
                    <select id="seirekiYear" name="seirekiYear"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </select>
                </div>

                <!-- 和暦入力 -->
                <div id="warekiInput" class="space-y-2">
                    <label class="block font-semibold text-gray-700">和暦:</label>
                    <div class="flex flex-wrap gap-2">
                        <!-- 元号 -->
                        <div class="flex-1 min-w-[40%]">
                            <select id="era" name="era"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- 選択 --</option>
                                <option value="reiwa">令和</option>
                                <option value="heisei">平成</option>
                                <option value="showa">昭和</option>
                            </select>
                        </div>

                        <!-- 年 -->
                        <div class="flex-1 min-w-[40%]">
                            <select id="warekiYear" name="warekiYear"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </select>
                        </div>
                    </div>
                </div>


                <!-- 月 -->
                <div>
                    <label for="month" class="block font-semibold text-gray-700">月:</label>
                    <select id="month" name="month"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </select>
                </div>

                <!-- 日 -->
                <div>
                    <label for="day" class="block font-semibold text-gray-700">日:</label>
                    <select id="day" name="day"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </select>
                </div>
            </form>

            <!-- リセットボタン -->
            <div class="pt-4 text-right">
                <button id="resetButton" type="button"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                    リセット
                </button>
            </div>


            <div id="result" class="mt-6 text-blue-700 font-medium"></div>
            <div id="milestoneResults" class="mt-2 text-sm text-gray-700 space-y-1"></div>
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

                // disabled解除
                seirekiYear.disabled = false;
                warekiYear.disabled = false;
                era.disabled = false;

                // 表示クリア
                document.getElementById('result').innerText = '';
                document.getElementById('milestoneResults').innerText = '';
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
                if (seirekiYear.value) {
                    warekiYear.disabled = true;
                    era.disabled = true;
                } else if (warekiYear.value) {
                    seirekiYear.disabled = true;
                } else {
                    seirekiYear.disabled = false;
                    warekiYear.disabled = false;
                    era.disabled = false;
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
    </script>



</x-app-layout>