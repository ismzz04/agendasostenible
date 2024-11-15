$(document).ready(function () {
    function loadEvents(filters = {}) {
        $.ajax({
            url: 'load_events.php',
            type: 'GET',
            data: filters,
            dataType: 'json',
            success: function (response) {
                if (response.html && response.html.trim() !== '') {
                    $('#event-container').html(response.html);
                } else {
                    $('#event-container').html('<p>No s\'han trobat esdeveniments amb els filtres aplicats.</p>');
                }
            },
            error: function () {
                alert('Hi ha hagut un error en carregar els esdeveniments.');
            }
        });
    }

    $('#filter-btn').click(function () {
        const filters = {
            name: $('#event-name').val(),
            start_date: $('#start-date').val(),
            tipus: $('#tipus').val()
        };
        loadEvents(filters);
    });

    // Carga inicial sin filtros
    loadEvents();
});
