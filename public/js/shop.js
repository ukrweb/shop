$(document).ready(function() {
    $('#supplier_list, #supplier_stock_list, #contragent_list, #product_list').DataTable({
        "aLengthMenu" : [[10, 25, 50, -1], [10, 25, 50, "Все"]],
        "stateSave"   : true,
        "fixedHeader" : true,
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.childRowImmediate,
                type: 'column'
            }
        },
        columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   0
        } ],
        order: [ 1, 'asc' ],
        dom: 'lBfrtip<"actions">',
        buttons: [
            'excelHtml5',
            'csvHtml5',{
                name: 'colvis',
                extend: 'colvis',
                columns: [':gt(1)']
            },
        ],
        language: {  
            "processing": "Подождите...",
            "search": "Поиск:",
            "lengthMenu": "Показать _MENU_ записей",
            "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
            "infoEmpty": "Записи с 0 до 0 из 0 записей",
            "infoFiltered": "(отфильтровано из _MAX_ записей)",
            "infoPostFix": "",
            "loadingRecords": "Загрузка записей...",
            "zeroRecords": "Записи отсутствуют.",
            "emptyTable": "В таблице отсутствуют данные",
            "paginate": {
        	    "first": "Первая",
        	    "previous": "Предыдущая",
        	    "next": "Следующая",
        	    "last": "Последняя"
            },
            "aria": {
        	    "sortAscending": ": активировать для сортировки столбца по возрастанию",
        	    "sortDescending": ": активировать для сортировки столбца по убыванию"
            },

            buttons: {
                'pageLength': 'Показать %d записей',
                'colvis': 'Показать/скрыть колонки'
            }
        }
    });

    var supplier_category_list = $('#supplier_category_list').DataTable({
        "aLengthMenu" : [[10, 25, 50, -1], [10, 25, 50, "Все"]],
        "stateSave"   : false,
        "fixedHeader" : true,
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.childRowImmediate,
                type: 'column'
            }
        },
        columnDefs: [
        	{
	        	orderable: false,
	            className: 'control',
	            targets: [0]
            },
        	{
	        	orderable: false,
	        	className: 'select-checkbox',
	            targets: [1]
            }
        ],
        order: [ 2, 'asc' ],
        dom: 'lBfrtip<"actions">',
        buttons: [
            'excelHtml5',
            'csvHtml5',{
                name: 'colvis',
                extend: 'colvis',
                columns: [':gt(2)']
            },
        ],
        language: {  
            "processing": "Подождите...",
            "search": "Поиск:",
            "lengthMenu": "Показать _MENU_ записей",
            "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
            "infoEmpty": "Записи с 0 до 0 из 0 записей",
            "infoFiltered": "(отфильтровано из _MAX_ записей)",
            "infoPostFix": "",
            "loadingRecords": "Загрузка записей...",
            "zeroRecords": "Записи отсутствуют.",
            "emptyTable": "В таблице отсутствуют данные",
            "paginate": {
        	    "first": "Первая",
        	    "previous": "Пред",
        	    "next": "След",
        	    "last": "Последняя"
            },
            "aria": {
        	    "sortAscending": ": активировать для сортировки столбца по возрастанию",
        	    "sortDescending": ": активировать для сортировки столбца по убыванию"
            },

            buttons: {
                'pageLength': 'Показать %d записей',
                'colvis': 'Показать/скрыть колонки'
            }
        }
    });

    var col = 0;
    $('#supplier_category_list tfoot th').each( function () {
    	col++;
    	if (col > 2) {
    		switch (col) {
    		  case 3:
    		    size = 2;
    		    break;
    		  case 4:
      		    size = 10;
    		    break;
    		  case 5:
        		size = 40;
      		    break;
    		  case 6:
        		size = 2;
      		    break;
    		  default:
          		size = 20;
    		}
	        var title = $(this).text();
	        $(this).html( '<input type="text" size=' + size + ' placeholder="Поиск ' + title + '" />' );
    	}
    } );
 
    // Apply the search
    supplier_category_list.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change clear', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    });

    supplier_category_list.on('page.dt', function () {
        $('#select_all').prop('checked', $(this).is(''));
    });

    $('#select_all').change(function() {
        var checkboxes = $('#category').find(':checkbox');
        checkboxes.prop('checked', $(this).is(':checked'));

    });

    $("#party").suggestions({
        token: "e60a1a68b4578e788e20092a4ab8826aaf161bb7",
        type: "PARTY",
        /* Вызывается, когда пользователь выбирает одну из подсказок */
        onSelect: function(suggestion) {
        	$.ajax({
                type: "POST",
                url: "/is-contragent/check/" + suggestion.data.hid,
                success: function(data) {
                    if (data.success)
                    {
                    	jQuery.noConflict();
                    	$('#addContragentModal').modal('show');
                    }
                    fillFields(suggestion);
                }
            });
        },
    });

    $("#default_contragent_id").select2({
    	language: "ru",
    	theme: 'bootstrap4',
    	ajax: {
    		url: function (params) {
    		      return '/contragents/search/5' + (params.term ? '/' + params.term : '');
    		},
            data: function (params) {
                return false;
            },
            processResults: function (data) {
    	        return {
    	          results: data.success
    	        };
            },
        },
    });

    $("#category_parent_id").select2({
    	language: "ru",
    	theme: 'bootstrap4',
    	ajax: {
    		url: function (params) {
    		    return '/categories/search/' + $("#category_id").val() + '/5' + (params.term ? '/' + params.term : '');
    		},
            data: function (params) {
                return false;
            },
            processResults: function (data) {
    	        return {
    	          results: data.success
    	        };
            },
        },
    });

    $("#oc_category_id").select2({
    	language: "ru",
    	theme: 'bootstrap4',
    	ajax: {
    		url: function (params) {
  		        return '/os-categories/os-categories-search/5' + (params.term ? '/' + params.term : '');
    		},
            data: function (params) {
                return false;
            },
            processResults: function (data) {
    	        return {
    	          results: data.success
    	        };
            },
        },
    });

    $("#supplier_category").select2({
    	language: "ru",
    	theme: 'bootstrap4',
    	ajax: {
    		url: function (params) {
    		    return '/categories/search/' + $("#category_id").val() + '/5' + (params.term ? '/' + params.term : '');
    		},
            data: function (params) {
                return false;
            },
            processResults: function (data) {
    	        return {
    	          results: data.success
    	        };
            },
        },
    });
});

function dateFormat(timestamp) {
    if (timestamp) {
    	return new Date(timestamp).toLocaleDateString();
    }
}

function fillFields(suggestion) {
    $("#value").val(suggestion.value);
    $("#unrestricted_value").val(suggestion.unrestricted_value);
    $("#data_address_value").val(suggestion.data.address.value);
    $("#data_address_unrestricted_value").val(suggestion.data.address.unrestricted_value);
    $("#data_address_data_source").val(suggestion.data.address.data.source);
    $("#data_address_data_qc").val(suggestion.data.address.data.qc);
    $("#data_branch_count").val(suggestion.data.branch_count);
    if (suggestion.data.branch_type) {
    	$("#data_branch_type").val(suggestion.data.branch_type);
    } else {
    	$("#data_branch_type").val(-1);
    }
    
    $("#data_inn").val(suggestion.data.inn);
    $("#data_kpp").val(suggestion.data.kpp);
    $("#data_ogrn").val(suggestion.data.ogrn);
    $("#data_ogrn_date").val(dateFormat(suggestion.data.ogrn_date));
    $("#data_hid").val(suggestion.data.hid);
    if (suggestion.data.management) {
        $("#data_management_name").val(suggestion.data.management.name);
   	    $("#data_management_post").val(suggestion.data.management.post);
    } else {
        $("#data_management_name").val('');
   	    $("#data_management_post").val('');
    }
    $("#data_name_full_with_opf").val(suggestion.data.name.full_with_opf);
    $("#data_name_short_with_opf").val(suggestion.data.name.short_with_opf);
    $("#data_name_latin").val(suggestion.data.name.latin);
    $("#data_name_full").val(suggestion.data.name.full);
    $("#data_name_short").val(suggestion.data.name.short);
    $("#data_okpo").val(suggestion.data.okpo);
    $("#data_okved").val(suggestion.data.okved);
    $("#data_okved_type").val(suggestion.data.okved_type);
    $("#data_opf_code").val(suggestion.data.opf.code);
    $("#data_opf_full").val(suggestion.data.opf.full);
    $("#data_opf_short").val(suggestion.data.opf.short);
    $("#data_opf_type").val(suggestion.data.opf.type);
    $("#data_state_actuality_date").val(dateFormat(suggestion.data.state.actuality_date));
    $("#data_state_registration_date").val(dateFormat(suggestion.data.state.registration_date));
    $("#data_state_liquidation_date").val(dateFormat(suggestion.data.state.liquidation_date));
    $("#data_state_status").val(suggestion.data.state.status);
    $("#data_type").val(suggestion.data.type);
}