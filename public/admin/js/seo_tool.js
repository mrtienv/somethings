$(window).on('load', function () {
    String.prototype.trimEnd = function (c) {
        c = c ? c : ' ';
        var i = this.length - 1;
        for (; i >= 0 && this.charAt(i) == c; i--) ;
        return this.substring(0, i + 1);
    }

    function htmlEncode(value) {
        return $('<div/>').text(value).html();
    }

    function updateCounts() {

        if ($("#title-sizer").width() < 400) {
            $('#title-count-text').removeClass('text-success').addClass('text-danger');
        } else if ($("#title-sizer").width() <= 500 && $("#title-sizer").width() >= 400) {
            $('#title-count-text').removeClass('text-danger').addClass('text-success');
        } else {
            $('#title-count-text').removeClass('text-success').addClass('text-danger');
        }

        if ($("#description-sizer").width() < 800) {
            $('#description-count-text').removeClass('text-success').addClass('text-danger');

        } else if ($("#description-sizer").width() <= 900 && $("#description-sizer").width() >= 800) {
            $('#description-count-text').removeClass('text-danger').addClass('text-success');
        } else {
            $('#description-count-text').removeClass('text-success').addClass('text-danger');
        }

        $('.result-icon').remove();
        $('.success').remove();
        $('.failure').remove();

        $('#title-count').text(parseInt($("#title-sizer").width()));

        $('#description-count').text(parseInt($("#description-sizer").width()));

    }

    function updateTitle() {
        var rawTitle = $.trim($("input[name=meta_title]").val());
        var title = htmlEncode(rawTitle);

        $("#title-sizer").html(title);
        $("#title-sizer-temp").html(title);

        var lastWord = new RegExp("\\S+$");

        while ($("#title-sizer-temp").width() > 580) {
            title = $.trim(title.replace(" <b>...</b>", ""));
            var newTitle = title;
            newTitle = $.trim(newTitle.replace(lastWord, ""));

            if (newTitle.length >= title.length) {
                // failed to shrink more. force crop it
                newTitle = newTitle.substring(0, newTitle.length - 1);
            }
            title = newTitle + " <b>...</b>";
            $("#title-sizer-temp").html(title);
        }


        if ($("input[name=meta_title]").val().length > 0) {
            $("#title-count-text").show();
        }
    }

    function updateDescription() {
        var rawDescription = $.trim($('textarea[name=meta_description]').val());
        var description = htmlEncode(rawDescription);

        $("#description-sizer").html(description);
        $("#description-sizer-temp").html(description);

        var lastWord = new RegExp("\\S+$");

        while ($("#description-sizer-temp").width() > 930) {
            description = $.trim(description.replace(" <b>...</b>", ""));

            var newDescription = description;

            newDescription = $.trim(newDescription.replace(lastWord, ""));
            rawDescription = $.trim(rawDescription.replace(lastWord, ""));

            if (newDescription.length >= description.length) {
                // failed to shrink more. force crop it
                newDescription = newDescription.substring(0, newDescription.length - 1);
                rawDescription = rawDescription.substring(0, rawDescription.length - 1);
            }

            description = newDescription + " <b>...</b>";
            $("#description-sizer-temp").html(description);
        }

        if ($('textarea[name=meta_description]').val().length > 0) {
            $("#description-count-text").show();
        }
    }

    function updateAll() {
        updateTitle();
        updateDescription();
        updateCounts();
    }

    $("input[name=meta_title]").keyup(function () {
        updateTitle();
        updateCounts();
    });

    $('textarea[name=meta_description]').keyup(function () {
        updateDescription();
        updateCounts();
    });

    var timer;
    $("input[name=meta_keyword]").bind('keyup', function () {
        clearTimeout(timer);
        timer = setTimeout(changeFn, 2000)
    });

    function changeFn(){
        theEditor = tinymce.editors[0];
        content = theEditor.getContent({ format: "text" });
        wordCount = theEditor.plugins.wordcount.getCount();
        seo_content(content,wordCount);
    }

    if ($("input[name=meta_title]").length > 0) updateAll();
    changeFn();
});

function seo_content(data_content, count_word) {
    if ($('input[name="meta_keyword"]').length > 0 && data_content.trim() !== '') {
        if ($('input[name="meta_keyword"]').val() !== '') {
            var keyword_in_content = 0;
            var keyword_length = 0;
            var val_keyword = $('input[name="meta_keyword"]').val();
            var keyword_arr = val_keyword.split(',');
            $.each(keyword_arr, function (k,v) {
                var regex = new RegExp(v.trim(), 'gim');
                var count = (data_content.match(regex) || []).length;
                keyword_in_content += count;
                keyword_length += v.trim().split(' ').length;
            });
            var percent = (keyword_length*keyword_in_content)/count_word*100;
            /*if (keyword_in_content > 3) {}*/
            $('#keyword-count').text(keyword_in_content);
            $('#keyword-count-percent').text(percent.toFixed(1));
        }
    }
}
