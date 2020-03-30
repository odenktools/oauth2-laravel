var INIT = {
    run: function(){
        this.tooltip();
        this.icheck();
        this.select2();
        this.preloader();
        this.prepareAjax();
    },
    tooltip: function(){
        $('[title], [data-title]').tooltip();
    },
    icheck: function(){
        $('.checkbox.icheck [type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    },
    select2: function(){
        $('.select2').select2({
            placeholder: function(){
                $(this).data('placeholder');
            },
            allowClear: true
        });
    },
    preloader: function(){
        var $preloader = $('#preloader'),
        $spinner = $preloader.find('.spinner');
        $spinner.fadeOut();
        $preloader.delay(500).fadeOut('slow');
        window.scrollTo(0, 0);
    },
    prepareAjax: function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
}

var CALL = {
    clearModalBackground: function(modal){
        $(modal).find('.modal-header')
            .removeClass('modal-primary')
            .removeClass('modal-success')
            .removeClass('modal-info')
            .removeClass('modal-warning')
            .removeClass('modal-danger');
    },
    previewImage: function (input, image){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(image).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    },
}

var MODAL = {
    run: function(){
        this.action();
        this.form();
    },
    action: function(button){
        var me = '#modal-action';

        if (button==undefined) {
            button = '.btn-modal-action';
        }

        $(document).on('click', button, function(e){
            var href = $(this).data('href');
            var title = $(this).data('title');
            var icon = $(this).data('icon');
            var background = $(this).data('background');

            if (icon==undefined) {
                icon = '';
            } else {
                icon = '<i class="'+ icon +'"></i>';
            }

            $.ajax({
                url: href,
                type: 'GET',
                dataType: 'HTML',
                success: function (data) {
                    CALL.clearModalBackground(me);
                    $(me).find('.modal-header').addClass(background);
                    $(me).find('.modal-title').html(icon + title);
                    $(me).find('.modal-body').html(data);
                    $(me).modal('show');
                    INIT.run();
                }
            });

            e.preventDefault();
        });
    },
    form: function(button){
        var me = '#modal-form';

        if (button==undefined) {
            button = '.btn-modal-form';
        }

        $(document).on('click', button, function(e){
            var href = $(this).data('href');
            var title = $(this).data('title');
            var icon = $(this).data('icon');
            var background = $(this).data('background');

            if (icon==undefined) {
                icon = '';
            } else {
                icon = '<i class="'+ icon +'"></i>';
            }

            $.ajax({
                url: href,
                type: 'GET',
                dataType: 'HTML',
                success: function (data) {
                    CALL.clearModalBackground(me);
                    $(me).find('.modal-header').addClass(background);
                    $(me).find('.modal-title').html(icon + title);
                    $(me).find('.modal-body').html(data);
                    $(me).modal('show');
                    INIT.run();
                }
            });

            e.preventDefault();
        });

        $(document).on('click', me + ' [type="submit"]', function(e){
            var form = $(this).parents('form');
            var action = $(form).attr('action');

            var formData = new FormData($(form)[0]);

            $.ajax({
                url: action,
                type: 'POST',
                dataType: 'HTML',
                data: formData,
                enctype: "multipart/form-data",
                cache:false,
                contentType: false,
                processData: false,
                success: function (data) {
                    try {
                        data = JSON.parse(data);
                        if (data.redirect!=undefined) {
                            window.location.href = data.redirect;
                        }
                    } catch(e) {
                        $(me).find('.modal-body').html(data);
                    }
                    INIT.run();
                }
            });

            e.preventDefault();
        });
    },
}

var PUSHER = {
    run: function () {
        this.bindEvents();
        this.initPusher();
        this.initTemplate();
    },
    bindEvents: function () {
        this.$menu = $('.notifications-menu');
        this.$menu.find('.menu').find('li').on('click', function () {
            PUSHER.markAsRead(this);
        });
    },
    initPusher: function () {
        this.pusher = new Pusher(window.config.pusher.key, {
            cluster: window.config.pusher.cluster,
            encrypted: window.config.pusher.encrypted
        });

        this.channel = this.pusher.subscribe('my-channel');
        this.channel.bind('App\\Events\\MerchantReplyEvent', this.count.bind(this));
    },
    initTemplate: function () {
        this.countTemplate = '<i class="fa fa-bell-o"></i><span class="label label-warning">{{count}}</span>';
        this.headerTemplate = 'You have {{count}} unread notifications';
        this.listTemplate = '<li{{style}} data-id="{{id}}"><a href="#">{{body}}</a></li>';
    },
    count: function (data) {
        this.setCount(data.count);
        this.setHeader(data.count);
        this.setList(data.notifications);
    },
    setCount: function (count) {
        var countTemplate = this.countTemplate;
        countTemplate = countTemplate.replace('{{count}}', count);
        this.$menu.find('.dropdown-toggle').html(countTemplate);
    },
    setHeader: function (count) {
        var headerTemplate = this.headerTemplate;
        headerTemplate = headerTemplate.replace('{{count}}', count);
        this.$menu.find('.header').html(headerTemplate);
    },
    setList: function (notifications) {
        console.log(notifications);
        var listTemplate = '';
        var listStyle = '';
        var listTemplateAll = '';

        for (var i = notifications.length - 1; i >= 0; i--) {
            listTemplate = this.listTemplate;
            listStyle = ' style="background-color:#4444441c;"';
            if (notifications[i].read_at) {
                listStyle = '';
            }
            listTemplate = listTemplate.replace('{{style}}', listStyle);
            listTemplate = listTemplate.replace('{{id}}', notifications[i].id);
            listTemplateAll += listTemplate.replace('{{body}}', notifications[i].data.body);
        }

        this.$menu.find('.menu').html(listTemplateAll);
    },
    markAsRead: function (e) {
        var self = this;
        $.ajax({
            url: '/admin/notifications-mark',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({
                id: $(e).attr('data-id')
            }),
            cache:false,
            contentType: 'application/json',
            success: function (data) {
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            }
        });
    }
};

$(function(){
    INIT.run();
    MODAL.run();
    PUSHER.run();
});
