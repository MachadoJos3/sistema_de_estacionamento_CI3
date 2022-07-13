$(document).ready(function() {

    var table = $('.data-table').DataTable({//onde houver uma ocorrencia da classe data-table execute
        responsive: true,
        select: true,
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': ['nosort']
        }]
    });

});