CKEDITOR.replace('editor1');

$('.delete').click(function () {
    var res = confirm('Подтвердите действие');
    if (!res) return false;
});

// var url = window.location.protocol + '//' + window.location.host + window.location.pathname;
// $('.sidebar-menu a').filter(function () {
//     return this.href == url;
// }).addClass('active');

// for treeview
// $('ul.treeview a').filter(function() {
//     return this.href == url;
// }).parentsUntil(".sidebar > .treeview").addClass('menu-open').prev('a').addClass('active');

$('.sidebar-menu a').each(function () {
    var location = window.location.protocol + '//' + window.location.host + window.location.pathname;
    var link = this.href;
    if (link === location) {
        $(this).parent().addClass('active');
        $(this).closest('.treeview').addClass('active');
    }
});

$('#reset-filter').click(function () {
    $('#filter input[type=radio]').prop('checked', false);
    return false;
});

$(".select2").select2({
    placeholder: "Начните вводить наименование товара",
    // minimumInputLength: 2,
    cache: true,
    ajax: {
        url: adminpath + "/product/related-product",
        delay: 250,
        dataType: 'json',
        data: function (params) {
            return {
                q: params.term,
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                results: data.items,
            };
        },
    }
});
