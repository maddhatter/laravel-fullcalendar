<script>
    $('#calendar-{{ $id }}').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        eventLimit: true,
        events: {{ $events }}
    });
</script>