function posSelect(selector, placeholder = 'Select an option', parentId = null) {
  const $el = $('#' + selector);
  if (!$el.length || !$el.is('select')) return;

  $el.select2({
    placeholder: placeholder,
    allowClear: true,
    width: '100%',
    minimumResultsForSearch: 0,
    dropdownParent: parentId ? $('#' + parentId) : $(document.body)
  });

  $el.on('select2:open', () => {
    document.querySelector('.select2-search__field')?.focus();
  });
}
$(function () {
  $("input[data-bootstrap-switch]").each(function () {
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  })
});
$(function () {
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$('.before_ajx').hide();
$(function () {

  $("#example1").DataTable({
    buttons: {
      buttons: [
        'copy',
        {
          text: 'My button',
          action: function (dt) {
            console.log('My custom button!');
          }
        }
      ]
    },
    "responsive": false,
    // "scrollX": true,
    "iDisplayLength": 100
  });
  $("#insorance").DataTable({
    buttons: {
      buttons: [
        'copy',
        {
          text: 'My button',
          action: function (dt) {
            console.log('My custom button!');
          }
        }
      ]
    },
    "responsive": true,
    "autoWidth": false,
    scrollY: '100vh',
    scrollCollapse: true,
  });
  $("#barcode_items").DataTable({
    dom: 'Bfrtip',
    ordering: true,
    buttons: [{
      extend: 'excelHtml5',
      text: '<i class="fa fa-file-excel-o"></i> Excel',
      titleAttr: 'Excel',
      className: "btn btn-warning",
      // title: 'Barcode Items Excel Sheet By POS',
      "title": '',
    },
    {
      extend: 'pdfHtml5',
      pageSize: 'LEGAL',
      text: '<i class="fa fa-file-pdf-o"></i> PDF',
      titleAttr: 'PDF',
      className: "btn btn-danger",
      title: 'Barcode Items PDF By POS',
    }
    ],
    iDisplayLength: 100
  });
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
    "iDisplayLength": 100,
  });
});
$(document).ready(function () {
  // Create DataTable
  var table = $('#searchDt').DataTable({
    dom: 'Qlfrtip',
    iDisplayLength: 100,
    searching: true,
    lengthChange: false,
    paging: true,
    searchBuilder: true,
  });
});
$(document).ready(function () {
  // DataTable initialisation
  $('#salebysalesperson').DataTable({
    "paging": true,
    "iDisplayLength": 20,
    "footerCallback": function (row, data, start, end, display) {
      var api = this.api();
      nb_cols = api.columns().nodes().length;
      var j = 4;
      while (j < nb_cols) {
        var pageTotal = api
          .column(j, {
            page: 'current'
          })
          .data()
          .reduce(function (a, b) {
            return Number(a) + Number(b);
          }, 0);
        // Update footer
        $(api.column(j).footer()).html("AED." + pageTotal.toFixed(2));
        j++;
      }
    }
  });
});
/*select2*/
$(function () {
  //Initialize Select2 Elements
  $('.select2').select2();
  $('.ItemPaackage').select2()
  //Initialize Select2 Elements
  $('.select2ret').select2({
    allowClear: true,
    theme: 'bootstrap4',
    placeholder: "Select a customer"
  })
  $('.select2bs4').select2({
    allowClear: true,
    theme: 'bootstrap4',
    placeholder: "Select a value"
  })

  $('.select2bs42').select2({
    allowClear: true,
    theme: 'bootstrap4',
    placeholder: "Select a value"
  })
  $(".filterdata").select2({
    theme: "classic"
  });
  $('.accountsby').select2({
    theme: 'bootstrap4'
  });
  $('.itemFilter').select2({
    allowClear: true,
    theme: 'bootstrap4',
    placeholder: "Select a value"
  });

})
function pack_line() {
  $(".pack_line").select2({
    theme: 'bootstrap4',
    ajax: {
      url: "model/zoho/search-item.php",
      type: "post",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          search_pack_line: params.term, // search term
        };
      },
      processResults: function (response) {
        return {
          results: response
        };
      },
      cache: true
    }

  });
}
// Define reusable initializer
function initCustomerSelect(selector, searchCustLocal) {
  $(selector).select2({
    theme: 'bootstrap4',
    ajax: {
      url: 'model/zoho/search-item.php',
      type: 'POST',
      dataType: 'json',
      delay: 250,
      data: function (params) {
        console.log("Searching for:", params.term);
        return {
          searchCustLocal: 1,
          q: params.term || '',
          page: params.page || 1
        };
      },
      processResults: function (data) {
        console.log("Data received from backend:", data);
        return {
          results: data.items
        };
      },
      error: function (jqXHR, status, error) {
        console.error("AJAX Error:", status, error);
      },
      cache: true
    },
    placeholder: '- Select Customer -',
    minimumInputLength: 0 // set to 0 for testing, change to 2 in production
  });
}

// Call it on document ready
$(document).ready(function () {
  initCustomerSelect('#posCustnv', 'searchCustLocal');        // your main dropdown
  initCustomerSelect('.customerSelect', 'searchCustLocal');
});
// items line
$(document).ready(function () {
  $(".lineItem").select2({
    theme: 'bootstrap4',
    ajax: {
      url: "model/zoho/search-item.php",
      type: "post",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          searching: params.term ?? '', // search term
        };
      },
      processResults: function (response) {
        return {
          results: response
        };
      },
      cache: true
    }
  });
});
// warranty line items
$(document).ready(function () {
  $(".warranty_lines,.select2bs4").select2({
    theme: 'bootstrap-5',
  });
});
// search customer
$(document).ready(function () {
  initDynamicSelect2();
});
function initDynamicSelect2($parent = $('body')) {
  const select2Configs = {
    '.custSearch': 'searchCust',
    '.custSearch_ret': 'searchCust',
    '.searchVend': 'searchVend',
    '.searchUser': 'searchUser',
    '.searchSales': 'searchSales',
    '.searchTask': 'searchTask',
    '.searchTodo': 'searchTodo',
    '.sku_search': 'sku_search',
    '.brand_search': 'brand_search',
    '.model_search': 'model_search',
    '.item_searching': 'item_searching',
    '.lineItem': 'searching',
  };

  for (const [selector, paramKey] of Object.entries(select2Configs)) {
    $parent.find(selector).each(function () {
      if (!$(this).hasClass('select2-hidden-accessible')) {
        const $modal = $(this).closest('.modal');
        $(this).select2({
          theme: 'bootstrap-5',
          dropdownParent: $modal.length ? $modal : $('body'),
          placeholder: 'Select a value',
          allowClear: true,
          width: '100%',
          ajax: {
            url: 'model/zoho/search-item.php',
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: params => ({ [paramKey]: params.term ?? '' }),
            processResults: response => ({ results: response }),
            cache: true
          }
        });
      }
    });
  }
}
// validation bootstrap
$(document).ready(function () {
  $('.dynamic_form').on('submit', function (e) {
    const $form = $(this);
    let isValid = true;

    $form.find('[data-validate]').each(function () {
      const $field = $(this);
      const rules = $field.data('validate').split('|');
      const label = $field.data('label') || $field.attr('name');
      const val = $field.val().trim();
      let fieldValid = true;

      for (let rule of rules) {
        if (rule === 'required' && val === '') fieldValid = false;
        if (rule === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) fieldValid = false;
        if (rule.startsWith('min:')) {
          const min = parseInt(rule.split(':')[1]);
          if (val.length < min) fieldValid = false;
        }
        if (rule === 'phone' && !/^\+?\d{7,15}$/.test(val)) fieldValid = false;
      }

      $field.toggleClass('is-invalid', !fieldValid);
      $field.toggleClass('is-valid', fieldValid);

      if (!fieldValid) {
        isValid = false;
        if ($field.next('.invalid-feedback').length === 0) {
          $field.after(`<div class="invalid-feedback">Invalid ${label}</div>`);
        }
      } else {
        $field.next('.invalid-feedback').remove();
      }
    });

    if (!isValid) {
      e.preventDefault();
      e.stopPropagation();
    }
  });

  // ✅ Live feedback on input/change
  $(document).on('input change', '[data-validate]', function () {
    const $field = $(this);
    const rules = $field.data('validate').split('|');
    const val = $field.val().trim();
    let fieldValid = true;

    for (let rule of rules) {
      if (rule === 'required' && val === '') fieldValid = false;
      if (rule === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) fieldValid = false;
      if (rule.startsWith('min:')) {
        const min = parseInt(rule.split(':')[1]);
        if (val.length < min) fieldValid = false;
      }
      if (rule === 'phone' && !/^\+?\d{7,15}$/.test(val)) fieldValid = false;
    }

    $field.toggleClass('is-invalid', !fieldValid);
    $field.toggleClass('is-valid', fieldValid);
    if (fieldValid) $field.next('.invalid-feedback').remove();
  });
});