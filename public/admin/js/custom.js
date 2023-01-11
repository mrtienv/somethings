$(document).ready(function () {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
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
    };
});


$(document).on('click', '.ajax-login', function (e) {
    e.preventDefault();
    let form = $(this).closest('form');
    let url = form.attr('action');
    let data = form.serialize();
    $.ajax({
        url: url,
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success'){
                window.location.href = '/admin/home';
            } else {
                alert('Tài khoản hoặc mật khẩu không đúng!');
                form[0].reset();
                return false;
            }
        }
    })
});

$(document).on('keypress', 'input[name="password"]',function(e) {
    if(e.which === 13) {
        $('.ajax-login').trigger('click');
    }
});

$(document).on('keypress', '.customValidity', function (e) {
    $(this).get(0).setCustomValidity("");
});

function checkEmptyCustomValidity() {
    $('.customValidity').each(function () {
        if (!$(this).val()) {
            $(this).get(0).setCustomValidity("Không được để trống!");
            $(this).get(0).reportValidity();
            return false;
        }
    });
    return true;
}

$(document).on('click', '.btn-change-password', function (e) {
    e.preventDefault();
    if (!checkEmptyCustomValidity()) return;
    let input_old_password = $('#changePassword input[name="old_password"]');
    let input_new_password = $('#changePassword input[name="new_password"]');
    let input_re_password = $('#changePassword input[name="re_password"]');
    let old_password = input_old_password.val();
    let new_password = input_new_password.val();
    let re_password = input_re_password.val();
    if (re_password !== new_password) {
        input_re_password.get(0).setCustomValidity("Mật khẩu nhập lại chưa đúng!");
        input_re_password.get(0).reportValidity();
        return false;
    }
    $.ajax({
        url: '/admin/ajax/changePassword',
        data: {
            old_password: old_password,
            new_password: new_password
        },
        type: 'POST',
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success'){
                $('#changePassword').modal('hide');
                showToastr('success', res.message);
            } else {
                input_old_password.get(0).setCustomValidity("Mật khẩu cũ không đúng!");
                input_old_password.get(0).reportValidity();
            }
        }
    })
});

function upload_file(mode,control){
    let open_url = '/admin/libraries/elfinder/file-elfinder.php?mode='+mode+'&control='+control;
    window.open(open_url,'_blank',"location=0,left=200,width=800,height=500");
    return false;
}

if (document.getElementById('select-multi-tag')) {
    let post_id = $('#select-multi-tag').data('post-id');
    $.ajax({
        url: '/admin/ajax/loadTag',
        type: 'POST',
        data: {
            post_id: post_id
        },
        dataType: "json",
        success: function(data) {
            if (data.list_tag) {
                let options = data.list_tag;
                let select = document.getElementById('select-multi-tag');
                new coreui.MultiSelect(select, {
                    multiple: true,
                    selectionType: 'tags',
                    search: true,
                    options: options
                });
            }
            if (data.tag_selected) {
                data.tag_selected.forEach((item) => {
                    $('.c-multi-select-option[data-value="'+item+'"]').trigger('click');
                });
            }
        }
    });

    $('form').submit(function() {
        let container = $('#select-multi-tag').parent();
        $(container).find('.c-multi-select-selection .c-multi-select-tag').each(function () {
            let id = $(this).data('value');
            $(this).append('<input type="hidden" name="tag[]" value="'+id+'">');
        });
        return true;
    });
}
$(document).ready(function () {
    if (typeof $('#nestable')[0] != 'undefined') {
        var container = $('#nestable');
        container.nestable({
            group: 1,
            maxDepth: 2
        }).change(function () {
            updateOutput(container);
        });
        $('.category_select').click(function(){
            var category = $('select[name=category_id]');
            var option = $('option:selected', category);
            var url = option.data('url');
            var title = option.data('title');
            title = title.replace(/-/g, '');
            appendEditMenuItem(container, title, url);
            updateOutput(container);
            toggleEditMenuItem();
            editMenuItem();
            deleteMenuItem();
        });
        $('.link_select').click(function(){
            var url = $('input[name=custom_link]').val();
            appendEditMenuItem(container, url, '#');
            updateOutput(container);
            toggleEditMenuItem();
            editMenuItem();
            deleteMenuItem();
        });
        var data = $('input[name=data]').val();
        if (data !== ''){
            listify(container, data);
            toggleEditMenuItem();
            editMenuItem();
            deleteMenuItem();
        }
    }
})
//Bắt sự kiện on change
// $(document).on('change', '.sl-type-post', function () {
//     let url = $(this).val();
//     window.location.href = url;
// });
let formEl = document.querySelector('.sl-type-post');
formEl.addEventListener('change', changeWindowLocation)
function changeWindowLocation() {
    let url = formEl.value;
    window.location.href = url;
}


function toggleEditMenuItem() {
    $(document).on('click', '.nestleeditd', function () {
        $(this).parent().siblings('div.menublock').toggleClass('d-none');
    });
}
function editMenuItem() {
    $('.apply_item').on('click',function () {
        var container = $(this).closest('li.dd-item');
        var name = container.find('.name_item').first().val();
        var url = container.find('.link_item').first().val();
        container.data('name', name);
        container.data('url', url);
        container.find('.dd-handle').first().text(name);
        updateOutput($('#nestable'));
        container.find('.nestleeditd').first().trigger('click');
    });
}
function deleteMenuItem() {
    $('.nestledeletedd').on('click',function (e) {
        e.preventDefault();
        var item;
        item = $(this).closest('li.dd-item');
        if (confirm('Bạn có chắc chắn xóa?')) {
            item.remove();
        }
        /*$('#smallModal').modal('show');
        $('.confirm_yes').click(function() {
            item.remove();
            $('#smallModal').modal('hide');
        })*/
        updateOutput($('#nestable'));
    });
}
function appendEditMenuItem(container, title, url) {
    var item = "<li class='dd-item' data-name='' data-url=''>\n" +
        "    <div class='dd-handle'></div>\n" +
        "    <div class='action-item'>\n" +
        "        <span class='nestleeditd'>\n" +
        "            <svg class='c-icon'>\n" +
        "                <use xlink:href='/admin/images/icon-svg/free.svg#cil-pencil'></use>\n" +
        "            </svg>\n" +
        "        </span>\n" +
        "        <span class='nestledeletedd'>\n" +
        "            <svg class='c-icon'>\n" +
        "                <use xlink:href='/admin/images/icon-svg/free.svg#cil-trash'></use>\n" +
        "            </svg>\n" +
        "        </span>\n" +
        "    </div>\n" +
        "    <div class='menublock d-none'>\n" +
        "        <input type='text' class='form-control name_item' value='' placeholder='Name'>\n" +
        "        <input type='text' class='form-control link_item' value='' placeholder='Link'>\n" +
        "        <input type='button' class='mt-1 btn btn-theme apply_item border' value='Apply'>\n" +
        "    </div>\n" +
        "</li>";
    item = $.parseHTML(item);
    $(item).data('name', title);
    $(item).data('url', url);
    $(item).find('.dd-handle').text(title);
    $(item).find('.name_item').val(title);
    $(item).find('.link_item').val(url);
    container.find('.dd-list').first().append(item);
    return item;
}
function updateOutput(e) {
    var list   = e.length ? e : $(e.target);
    if (window.JSON) {
        var data = window.JSON.stringify(list.nestable('serialize'));
        $('input[name=data]').val(data);
    }
}
function listify(container, strarr) {
    var obj = JSON.parse(strarr);
    if (!obj.length) obj = [obj];
    $.each(obj, function(i, v) {
        if (typeof v == 'object') {
            var name = v.name;
            var url = v.url;
            var parent = appendEditMenuItem(container,name,url);
            if (!!v.children){
                var div = "<ol class='dd-list'></ol>";
                $(parent).append(div);
                $.each(v.children, function(key, item) {
                    listify($(parent), JSON.stringify(item));
                });
            }
        }
    });
}
