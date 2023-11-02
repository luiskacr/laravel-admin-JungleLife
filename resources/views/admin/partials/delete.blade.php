<script>
    /**
     * Function to delete any model
     *
     * @param id
     * @param name
     * @param token
     * @param route
     * @param entity
     * @param callback
     */
    function deleteItem(id, name, token, route, entity, callback) {
        const f_route = route.slice(0, -1);
        Swal.fire({
            title: '{{ __('app.delete_title') }}',
            text: '{{ __('app.delete_text') }} ' + entity + ' ' + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '{{ __('app.delete_color') }}',
            cancelButtonColor: '{{__('app.cancelButtonColor')}}',
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
                            if(callback=== undefined){
                                location.reload();
                            }else{

                            }
                        })
                    },
                    error: function (request, status, error) {

                        if(error === 'Conflict'){
                            Swal.fire(
                                '{{ __('app.delete_error') }}',
                                request.responseText,
                                'error'
                            )
                        }else{
                            Swal.fire(
                                '{{ __('app.delete_error') }}',
                                '{{ __('app.delete_error_text') }}',
                                'error'
                            )

                            @if( app()->hasDebugModeEnabled() )
                                console.log(request.responseText)
                            @endif
                        }
                    },
                });
            }
        })
    }
</script>

