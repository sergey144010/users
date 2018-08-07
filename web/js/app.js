function init(){
    $(document).ready(
        function () {

            $('button.delete').each(function () {
                    $(this).on('click', function () {

                        var id = $(this).attr('id');
                        $.ajax({
                            url: "/remove/" + id,
                            type: "get",
                            success: function(data){
                                $('table.mainTable').html(data);
                                init();
                            },
                        });

                    });
                }
            );

            var grid2 = $('#filterTable');
            var options2 = {
                filteringRows: function(filterStates) {
                    grid2.addClass('filtering');
                },
                filteredRows: function(filterStates) {
                    grid2.removeClass('filtering');
                    setRowCountOnGrid2();
                }
            };
            function setRowCountOnGrid2() {
                var rowcount = grid2.find('tbody tr:not(:hidden)').length;
                $('#rowcount').text('(Rows ' + rowcount + ')');
            }

            grid2.tableFilter(options2);
            setRowCountOnGrid2();

        }
    );
};
init();