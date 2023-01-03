
@if (Session::has('success'))
    <script>
        Toastify({
            text: '{{ session('success') }}',
            avatar: 'https://api.iconify.design/gridicons/checkmark.svg?color=white',
            duration: 3000,
            className: "bg-success",
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "none",
            },
            onClick: function(){} // Callback after click
        }).showToast();
    </script>
@endif

@if (Session::has('error'))
    <script>
        Toastify({
            text: '{{ session('error') }}',
            avatar: 'https://api.iconify.design/ic/baseline-warning.svg?color=white',
            duration: 3000,
            className: "bg-danger",
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "none",
            },
            onClick: function(){} // Callback after click
        }).showToast();
    </script>
@endif

@if (Session::has('info'))
    <script>
        Toastify({
            text: '{{ session('info') }}',
            avatar: 'https://api.iconify.design/mdi/information-variant.svg?color=white',
            duration: 3000,
            className: "bg-info",
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "none",
            },
            onClick: function(){} // Callback after click
        }).showToast();
    </script>
@endif

@if (Session::has('message'))
    <script>
        Toastify({
            text: '{{ session('message') }}',
            avatar: 'https://api.iconify.design/mdi/information-variant.svg?color=white',
            duration: 3000,
            className: "bg-info",
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "none",
            },
            onClick: function(){} // Callback after click
        }).showToast();
    </script>
@endif

