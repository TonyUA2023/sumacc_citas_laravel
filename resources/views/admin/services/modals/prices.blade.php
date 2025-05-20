<div
    x-show="priceModalOpen"
    x-transition
    x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center overflow-auto p-4"
>
    <div @click.away="closePriceModal()" class="bg-white rounded p-6