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
