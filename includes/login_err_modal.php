<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Login Error</h5>
            </div>
            <div class="modal-body">
                <p>Given Login Input is invalid. Please try again or register. </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Try Again</button>
                <button type="button" id="registerButton" class="btn btn-primary">Register</button>
            </div>
        </div>
    </div>
</div>

<script> 
    document.getElementById('registerButton').addEventListener('click', function() {
        window.location.href = 'registration.php';
    });
</script>