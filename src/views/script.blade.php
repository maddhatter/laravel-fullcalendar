<script>
    // Wait for DOMContentLoaded event to emulate <script defer>
    // to ensure jQuery has loaded if it also has a defer attribute
    window.addEventListener('DOMContentLoaded', function() {
        $(document).ready(function(){
            $('#calendar-{{ $id }}').fullCalendar({!! $options !!});
        });
    });
</script>
