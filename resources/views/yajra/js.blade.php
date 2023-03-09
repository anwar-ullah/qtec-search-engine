<script type="text/javascript">
	$(document).ready(function() {
		var columns = [{
        	data: 'DT_RowIndex',
        	className: 'text-center',
        	'orderable': false,
        	'searchable': false,
        }];

        var headerColumns = <?php echo json_encode(isset($headerColumns) ? $headerColumns : []); ?>;
        $.each(headerColumns, function(index, val) {
        	if(index > 0){
        		columns.push({
		            data: val[0], 
		            name: val[1],
		            className: val[2],
		        });
        	}
        });

        var datatable_file_name = $('.datatable-serverside').attr('data-table-name');
		var table = $('.datatable-serverside').DataTable({
            bAutoWidth: false,
            processing: true,
            serverSide: true,
            ajax: location.href,
            columns: columns,

            lengthMenu: [
            	[ 50, 100, 500, 1000, -1 ],
            	[ '50 rows', '100 rows', '500 rows', '1000 rows', 'All Rows' ]
            ],

            language: {
              emptyTable: "No data available right now"
          	},

          	"oLanguage": {
			   "sSearch": ""
			 },
            
            sScrollXInner: "100%",
            scrollCollapse: true,

            dom: 'Bfrtip',
            buttons: [
                'pageLength',
                {
                    extend: 'copy',
                    title: datatable_file_name,
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                          page: 'all',
                        }
                    },
                    "action": serversideDataExport
                },
                {
                    extend: 'print',
                    title: datatable_file_name,
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                          page: 'all',
                        }
                    },
                    "action": serversideDataExport
                },
                {
                    extend: 'csv',
                    filename: datatable_file_name,
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                          page: 'all',
                        }
                    },
                    "action": serversideDataExport
                },
                {
                    extend: 'excel',
                    filename: datatable_file_name,
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                          page: 'all',
                        }
                    },
                    "action": serversideDataExport
                },
                {
                    extend: 'pdf',
                    filename: datatable_file_name,
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                          page: 'all',
                        }
                    },
                    "action": serversideDataExport
                }
            ],

            initComplete: function (settings, json) {
                $('.datatable-serverside').find('thead tr th').attr('style', 'padding: 5px !important;');
                var table = this.api();
                // Setup - Replace th with search_text class with input boxes
                table.columns().every(function () {
                    var column = this;
                    var header = $(column.header()).html();
                    var input = $('<input type="text" class="form-control text-center"  style="width: 100% !important;" placeholder="'+header+'"/><span style="display: none">'+header+'</span>')
                        .appendTo($(column.header())
                        .empty());
                    
                    //Restoring state
                    input.val(column.search());
                    
                    //Prevent enter key from sorting column
                    input.on('keypress', function (e) {
                        if (e.which == 13) {
                            e.preventDefault();
                            table.column($(this).parent().index() + ':visible').search(this.value).draw();
                            return false;
                        }
                    });

                    //Prevent click from sorting column
                    input.on('click', function (e) {
                        e.stopPropagation();
                    });

                    // There are 2 events fired on input element when clicking on the clear button:// mousedown and mouseup.
                    input.on('mouseup', function (e) {
                        var that = this;
                        var oldValue = this.value;
                        if (oldValue === '')
                            return;
                        
                        // When this event is fired after clicking on the clear button // the value is not cleared yet. We have to wait for it.
                        setTimeout(function () {
                            var newValue = that.value;
                            if (newValue === '') {
                                table.column($(that).parent().index() + ':visible').search(newValue).draw();
                                e.preventDefault();
                            }
                        }, 1);
                    });

                    //Make nodes tabbable withtout selecting td
                    input.parent().attr('tabindex', -1);
                });
            }
        });


        $('.buttons-collection').addClass('btn-sm');
        $('.buttons-copy').removeClass('btn-secondary').addClass('btn-sm btn-warning').html('<i class="fas fa-copy"></i>').attr('title', "Copy");
        $('.buttons-csv').removeClass('btn-secondary').addClass('btn-sm btn-success').html('<i class="fas fa-file-csv"></i>').attr('title', "CSV");
        $('.buttons-excel').removeClass('btn-secondary').addClass('btn-sm btn-primary').html('<i class="far fa-file-excel"></i>').attr('title', "Excel");
        $('.buttons-pdf').removeClass('btn-secondary').addClass('btn-sm btn-dark').html('<i class="fas fa-file-pdf"></i>').attr('title', "PDF");
        $('.buttons-print').removeClass('btn-secondary').addClass('btn-sm btn-dark').html('<i class="fas fa-print"></i>').attr('title', "Print");

        $('.dataTables_filter').find('input').attr('placeholder', 'Search Here...');
        $('.dataTables_paginate').find('.page-item').addClass('pl-0 pr-0');
        $('.datatable-serverside').parent().addClass('table-responsive');
	});

    function reloadDatatable() {
        $('.datatable-serverside').DataTable().ajax.reload();
    }

    function serversideDataExport(e, dt, button, config) {
         var self = this;
         var oldStart = dt.settings()[0]._iDisplayStart;
         dt.one('preXhr', function (e, s, data) {
            data.start = 0;
            data.length = 2147483647;
            dt.one('preDraw', function (e, settings) {
                if (button[0].className.indexOf('buttons-copy') >= 0) {
                    $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                    $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                    $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                    $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-print') >= 0) {
                    $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                }
                 
                 dt.one('preXhr', function (e, s, data) {
                    settings._iDisplayStart = oldStart;
                    data.start = oldStart;
                 });

                 if (button[0].className.indexOf('buttons-print') < 0){
                    setTimeout(dt.ajax.reload, 0);
                 }
                 return false;
             });
         });
         dt.ajax.reload();
    }
</script>