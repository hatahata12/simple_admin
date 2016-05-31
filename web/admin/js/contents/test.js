$(function() {

    var genre_data = [];

    // Editable
    $('.editable').editable({
        success: editSuccess,
        validate: function(value) {
            if($.trim(value) == '') {
                return '入力されていません';
            }
        }
    });

    function initValidation() {
        $("a[name^='valid_genre_code']").editable('option','validate', function (value) {
            if($.trim(value) == '') {
                return '入力されていません';
            }
            if (exitGenre(value)) {
                return 'すでに登録/追加済みのジャンルコードです';
            }
        });
        $("a[name^='valid_name']").editable('option','validate', function (value) {
            if($.trim(value) == '') {
                return '入力されていません';
            }
        });
        $("a[name^='valid_photo_move']").editable('option','validate', function (value) {
            if($.trim(value) == '') {
                return '入力されていません';
            }
            if (! $.isNumeric(value)) {
                return 'photo_moveは数字を入力してください';
            }
        });
        $("a[name^='valid_access_control']").editable('option','validate', function (value) {
            if($.trim(value) == '') {
                return '入力されていません';
            }
            if (! $.isNumeric(value)) {
                return 'access_controlは数字を入力してください';
            }
        });
    }

    $('#sortable').sortable();
    $('#sortable').disableSelection();

    $('#sortable').bind('sortstop', function (e, ui) {
        // ソートが完了したら実行される。
        var rows = $('#sortable .sort');
        for (var i = 0, rowTotal = rows.length; i < rowTotal; i += 1) {
            $($('.sort')[i]).text(i + 1);
            $($('.sort')[i]).parent().attr('id','sort_'+(i + 1));
        }
        loadGenre();
    });
    $('#genre_add').click(function(){
        var genre_code = $('#form_genre_code').val();
        var name = $('#form_name').val();
        var photo_move = $('#form_photo_move').val();
        var access_control = $('#access_control').val();

        if (! genre_code) {
            alert('genre_codeドを入力してください');
            return false;
        }

        if (! name) {
            alert('nameを入力してください');
            return false;
        }

        if (! photo_move) {
            alert('photo_moveを入力してください');
            return false;
        } else {
            if (! $.isNumeric(photo_move)) {
                alert('photo_moveは数字を入力してください');
                return false;
            }
        }

        if (! access_control) {
            alert('access_controlを入力してください');
            return false;
        } else {
            if (! $.isNumeric(access_control)) {
                alert('access_controlは数字を入力してください');
                return false;
            }
        }

        if (exitGenre(genre_code)) {
            alert('すでに登録/追加済みのジャンルコードです');
            return false;
        }

        var now = new Date();
        var y = now.getFullYear();
        var m = ("0"+now.getMonth() + 1).slice(-2);
        var d = ("0"+now.getDate()).slice(-2);
        var h = ("0"+now.getHours()).slice(-2);
        var i = ("0"+now.getMinutes()).slice(-2);
        var s = ("0"+now.getSeconds()).slice(-2);

        var updatetime = y + '/' + m + '/' + d + ' ' + h + ':' + i + ':' + s;
        var addTag = '<tr id="" class="genre_data"><td class="sort"></td>'+
        '<td class="value_genre_code"><a href="#" name="valid_genre_code" data-type="text" data-pk="1" data-title="Enter genre_code" class="editable editable-click" data-original-title="" title="">'+genre_code+'</a></td>'+
        '<td class="value_name"><a href="#" name="valid_name" data-type="text" data-pk="1" data-title="Enter name" class="editable editable-click" data-original-title="" title="">'+name+'</a></td>'+
        '<td class="value_photo_move"><a href="#" name="valid_photo_move" data-type="text" data-pk="1" data-title="Enter photo_move" class="editable editable-click" data-original-title="" title="">'+photo_move+'</a></td>'+
        '<td class="value_access_control"><a href="#" name="valid_access_control" data-type="text" data-pk="1" data-title="Enter access_control" class="editable editable-click" data-original-title="" title="">'+access_control+'</a></td>'+
        '<td class="value_updatetime">'+updatetime+'</td>'+
        '<td><span class="glyphicon glyphicon-remove-sign genre_delete"></span></td></tr>';
        $("#sortable").append(addTag);
        var rows = $('#sortable .sort');
        for (var i = 0, rowTotal = rows.length; i < rowTotal; i += 1) {
            $($('.sort')[i]).text(i + 1);
            $($('.sort')[i]).parent().attr('id','sort_'+(i + 1));
        }
        $('.editable').editable();
        loadGenre();
        initValidation();
        return false;
    });

    $(document).on('click', '.genre_delete' , function() {
        var sort = $(this).parent().parent().find('.sort').text();
        var genre_code = $(this).parent().parent().find('.value_genre_code a').text();
        var name = $(this).parent().parent().find('.value_name a').text();
        $('#genre_result').html('ジャンルを削除しました(sortnum : '+sort+', genre_code : '+genre_code+', name : '+name+')');
        $(this).parent().parent().remove();
        var rows = $('#sortable .sort');
        for (var i = 0, rowTotal = rows.length; i < rowTotal; i += 1) {
            $($('.sort')[i]).text(i + 1);
            $($('.sort')[i]).parent().attr('id','sort_'+(i + 1));
        }
        $('.editable').editable();
        loadGenre();
    });

    function loadGenre() {
        genre_data = [];
        $('#genre_table').find('tr').each(function() {
            var sort = $(this).find('.sort').text();
            var genre_code = $(this).find('.value_genre_code a').text();
            var name = $(this).find('.value_name a').text();
            var photo_move = $(this).find('.value_photo_move a').text();
            var access_control = $(this).find('.value_access_control a').text();
            var updatetime = $(this).find('.value_updatetime').text();
            if (sort) {
                genre_data.push(
                        {
                            'sortnum' : sort,
                            'genre_code' : genre_code,
                            'name' : name,
                            'photo_move' : photo_move,
                            'access_control' : access_control,
                            'updatetime' : updatetime
                        }
                );
            }

        });
        $('#submit_value').val($.toJSON(genre_data));
    }

    $("#update_genre").click(function(){
        $("#dialog-confirm").dialog({
            resizable : true,
            width : 450,
            height : 150,
            modal : true,
            buttons : {
                "キャンセル" : function() {
                    $(this).dialog("close");
                    return false;
                },
                '更新' : function() {
                    $(this).dialog("close");
                    $("#result").hide();
                    $("#genre_update_form").submit();
                }
            }
        });
        $('#dialog-confirm').show();
        return false;
    });

    function editSuccess(response, newValue) {
        $("#update_genre").attr("disabled", "disabled");
        $('#genre_result').html('編集しました('+newValue+')');
        sleep(1000, function (){ loadGenre();$("#update_genre").removeAttr("disabled"); } );
    }

    function exitGenre(genre_code) {
        for (genre in genre_data) {
            if (genre_data[genre].genre_code == genre_code) {
                return true;
            }
        }

        return false;
    }

    function sleep(time, callback){
        setTimeout(callback, time);
     }

    loadGenre();
    initValidation();
});
