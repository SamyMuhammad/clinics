<script>
    function reservationChangeStatus(element) {
        if (confirm("{{ __('reservations.status.changeConfirmation') }}")) {
            $.ajax({
                url: "{{ request()->routeIs('admin.*') ? route('admin.reservation.changeStatus') : route('reservation.changeStatus') }}",
                headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data:{
                    reservation_id: $(element).data('itemId'),
                    status: element.value
                },
                type: 'POST',
                success: function (response) {
                    // console.log(response);
                    if (response.status) {
                        alert(response.msg);
                    }
                }
            });
        }
    }
</script>