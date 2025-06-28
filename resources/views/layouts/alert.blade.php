@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible show fade" id="success-alert">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            <p>{{ $message }}</p>
        </div>
    </div>
@endif

<script>
    // Menghilangkan alert setelah 3 detik
    setTimeout(function() {
        let alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 2000);
</script>
