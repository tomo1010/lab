
<div class="max-w-6xl mx-auto px-4 py-8">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    <!-- Sticker Card -->
    <div class="bg-gray-150 rounded-lg shadow-lg">
      <div class="bg-pink-300 text-white p-4 rounded-t-lg">
        <h3 class="text-lg font-bold text-center"><a href="{{ route('baby.type', ['type' => 'sticker']) }}">シールタイプ</a></h3>
      </div>
      <div class="p-6">
        <p class="text-pink-700"><i class="fas fa-check-circle text-green-500"></i> どこでも貼れる、種類が多い</p>
        <p class="text-pink-700"><i class="fas fa-times-circle text-red-500"></i> サイズが大きいと貼るのが難しい、貼り直しができない</p>
      </div>
    </div>

    <!-- Magnet Card -->
    <div class="bg-gray-150 rounded-lg shadow-lg">
      <div class="bg-blue-300 text-white p-4 rounded-t-lg">
        <h3 class="text-lg font-bold text-center"><a href="{{ route('baby.type', ['type' => 'magnet']) }}">マグネットタイプ</a></h3>
      </div>
      <div class="p-6">
        <p class="text-pink-700"><i class="fas fa-check-circle text-green-500"></i> 気軽に貼り替え可能</p>
        <p class="text-pink-700"><i class="fas fa-times-circle text-red-500"></i> 鉄板部分にしか貼れない</p>
    <!-- Accordion Toggle Button -->
    <button onclick="toggleAccordion()" class="mt-4 text-blue-500 hover:text-blue-700 focus:outline-none text-sm ">
      ダイハツ系の車種は注意
    </button>
    
    <!-- Accordion Content -->
    <p id="accordion-content" class="text-gray-500 text-sm mt-2 hidden">
      軽自動車：タント、キャスト、キャンバス、ミライース、タフト、ムーヴ　普通車：ブーン、パッソ、トール、ルーミーなどはバックドアが樹脂製のためマグネットタイプは使えませんのでご注意を！
    </p>
      </div>
    </div>


<!-- Sucker Card with Accordion -->
<div class="bg-gray-150 rounded-lg shadow-lg">
  <div class="bg-green-300 text-white p-4 rounded-t-lg">
    <h3 class="text-lg font-bold text-center">
      <a href="{{ route('baby.type', ['type' => 'sucker']) }}">吸盤タイプ</a>
    </h3>
  </div>
  <div class="p-6">
    <p class="text-pink-700"><i class="fas fa-check-circle text-green-500"></i> 室内から貼るので盗まれない</p>
    <p class="text-pink-700"><i class="fas fa-times-circle text-red-500"></i> 濃いスモークガラスの場合、外から見えない</p>
  </div>
</div>

<!-- Simple JavaScript for Accordion Toggle -->
<script>
  function toggleAccordion() {
    const content = document.getElementById('accordion-content');
    content.classList.toggle('hidden');
  }
</script>



  </div>
</div>
