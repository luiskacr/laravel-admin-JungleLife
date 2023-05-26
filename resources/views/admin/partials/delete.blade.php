<script>

    const primaryElement = document.querySelector('.btn-primary')
    const primaryColor = getComputedStyle(primaryElement)


    function deleteItem(id, name, token, route) {
        const f_route = route.slice(0, -1);
        Swal.fire({
            title: '{{ __('app.delete_title') }}',
            text: '{{ __('app.delete_text' ,['object'=> __('app.type_guides_singular')]) }}  ' + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: primaryColor.backgroundColor,
            cancelButtonColor: '#ff3e1d',
            cancelButtonText: '{{ __('app.delete_cancelButtonText') }}',
            confirmButtonText: '{{ __('app.delete_confirmButtonText') }}'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: f_route + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: {
                        "id": id,
                        "_token": token
                    },
                    success: function () {
                        Swal.fire({
                            title: '{{ __('app.delete_success_tittle') }}',
                            text: '{{ __('app.delete_success') }}',
                            icon: 'success',
                        }).then((result) => {
                            location.reload();
                        })
                    },
                    error: function (xhr) {
                        Swal.fire(
                            '{{ __('app.delete_error') }}',
                            '{{ __('app.delete_error_text') }}',
                            'error'
                        )
                        @if(app()->hasDebugModeEnabled())
                        console.log(xhr.responseText)
                        @endif
                    },
                });
            }
        })
    }
</script>

