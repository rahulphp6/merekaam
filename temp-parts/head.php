<?php
// 1. Safe PHP Brand Check (Notice Fix)
$brand = isset($brand) ? strtolower($brand) : 'mytask';

$brand_logo = "mytask.png";
$favicon = "mytask.png";
$stylesheet = "styles.css";
?>
<!-- Viewport & Favicon -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="assets/images/<?php echo $favicon; ?>" type="image/x-icon">
<!-- Core jQuery (Must be in head) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Library / Plugin Css Build -->
<link rel="stylesheet" href="assets/css/core/libs.min.css">

<!-- Aos Animation Css -->
<link rel="stylesheet" href="assets/vendor/aos/dist/aos.css">
<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
<!-- Hope Ui Design System Css -->
<link rel="stylesheet" href="assets/css/hope-ui.css?v=4.0.0">
<!-- <link rel="stylesheet" href="assets/css/hope-ui.min.css?v=4.0.0"> -->
<!-- Custom Css -->
<link rel="stylesheet" href="assets/css/custom.min.css?v=4.0.0">

<!-- Dark Css -->
<link rel="stylesheet" href="assets/css/dark.min.css">

<!-- Customizer Css -->
<link rel="stylesheet" href="assets/css/customizer.min.css">
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
<!-- Select2 CSS -->
<link rel="stylesheet" href="plugins/select2/select2.min.css" />
<link rel="stylesheet" href="plugins/select2/select2-bootstrap-5-theme.min.css" />
<!-- RTL Css -->
<link rel="stylesheet" href="assets/css/rtl.min.css">
<link rel="stylesheet" href="<?php echo $stylesheet; ?>">
<!-- UI State Logic -->
<?php
$page = $_GET['page'] ?? ''; ?>
<script>
  const BASE_URL = '<?= rtrim(BASE_URL, '/') ?>/';
  // Global Toast Helper Definition
  function boom(message = 'Done', type = 'success', useSwal = false, useToastr = false) {
    // 1. SweetAlert2 Handling
    if (useSwal && typeof Swal !== 'undefined') {
      Swal.fire({
        toast: true,
        position: 'top-end',
        html: message,
        icon: type,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: { popup: 'colored-toast' }
      });
      return;
    }

    // 2. Toastr Handling
    if ((useToastr || !useSwal) && typeof toastr !== 'undefined') {
      const toastrMethod = typeof toastr[type] === 'function' ? type : 'info';
      toastr[toastrMethod](message);
      return;
    }

    // 3. Fallback Toast (Waits for DOM if body isn't ready)
    const renderFallback = () => {
      let toastEl = document.getElementById('liveToast');
      let toastMsg = document.getElementById('toastMessage');

      if (!toastEl) {
        if (!document.body) return; // Guard clause

        const container = document.createElement('div');
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '99999';
        container.innerHTML = `
          <div id="liveToast" class="toast align-items-center border-0 text-white" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
              <div class="toast-body" id="toastMessage"></div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>`;
        document.body.appendChild(container);

        toastEl = document.getElementById('liveToast');
        toastMsg = document.getElementById('toastMessage');
      }

      toastMsg.innerHTML = message;
      toastEl.classList.remove('bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'text-white', 'text-dark');
      const bgClass = type === 'warning' ? 'bg-warning text-dark' : `bg-${type === 'error' ? 'danger' : type} text-white`;
      toastEl.className = `toast align-items-center ${bgClass} border-0`;

      if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
        const bsToast = bootstrap.Toast.getOrCreateInstance(toastEl);
        bsToast.show();
      } else {
        toastEl.style.display = 'block';
        toastEl.style.opacity = '1';
        setTimeout(() => { toastEl.style.display = 'none'; }, 3000);
      }
    };

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', renderFallback);
    } else {
      renderFallback();
    }
  }
</script>