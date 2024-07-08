$(document).ready(function () {
    var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
        removeItemButton: true,
        maxItemCount: 7,
        searchResultLimit: 50,
        renderChoiceLimit: 50,
        noChoicesText: 'Tidak ada pilihan yang tersedia',
        itemSelectText: 'Tekan untuk memilih',
        addItemText: function (value) {
            return 'Tekan Enter untuk menambahkan <b>"' + value + '"</b>';
        },
        maxItemText: function (maxItemCount) {
            return 'Maksimal ' + maxItemCount + ' Genre yang dapat dipilih.';
        },
        // uniqueItemText: 'Item ini udah dipilih.',
        noResultsText: 'Gak ada Genre nya cok aowkaow',
        noChoicesText: 'Tidak ada pilihan yang tersedia',
        // searchPlaceholderValue: 'Mulai mengetik untuk mencari...',
        placeholder: true,
        placeholderValue: 'Pilih Maks 7 Genre',
        loadingText: 'Memuat...'
    });
});

$(document).ready(function () {
    var multipleCancelButton2 = new Choices('#choices-multiple-remove-button2', {
        removeItemButton: true,
        maxItemCount: 2,
        searchResultLimit: 50,
        renderChoiceLimit: 50,
        noChoicesText: 'Tidak ada pilihan yang tersedia',
        itemSelectText: 'Tekan untuk memilih',
        addItemText: function (value) {
            return 'Tekan Enter untuk menambahkan <b>"' + value + '"</b>';
        },
        maxItemText: function (maxItemCount) {
            return 'Maksimal ' + maxItemCount + ' Tag yang dapat dipilih.';
        },
        // uniqueItemText: 'Item ini sudah dipilih.',
        noResultsText: 'Gak ada tag nya cok aowkaow',
        noChoicesText: 'Tidak ada pilihan yang tersedia',
        // searchPlaceholderValue: 'Mulai mengetik untuk mencari...',
        placeholder: true,
        placeholderValue: 'Pilih Maks 2 Tags',
        loadingText: 'Memuat...'
    });
});