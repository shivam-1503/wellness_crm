(function() {
    "use strict";

    var slideMenu = $('.side-menu');
    $('.app').addClass('sidenav-toggled');
    $('.app').removeClass('sidenav-toggled-open');

    // Toggle Sidebar
    $(document).on('click', '[data-bs-toggle="sidebar"]', function(event) {
        event.preventDefault();
        $('.app').toggleClass('sidenav-toggled');
        $('.app').removeClass('sidenav-toggled-open');
    });

    $(document).on("click", ".sidenav-toggled .app-sidebar", function() {
        $('.app').addClass('sidenav-toggled-open');
    });

    $(document).on("click", ".sidenav-toggled.sidenav-toggled-open .app-content", function() {
        $('.app').removeClass('sidenav-toggled-open');
    });


    if ($(window).width() > 739) {
        $('.app').ready(function(event) {
            $('.app').removeClass('sidenav-toggled-open');
        });
    }



    // Activate sidebar slide toggle
    $("[data-bs-toggle='slide']").on('click', function(e) {
        var $this = $(this);
        var checkElement = $this.next();
        var animationSpeed = 300,
            slideMenuSelector = '.slide-menu';
        if (checkElement.is(slideMenuSelector) && checkElement.is(':visible')) {
            checkElement.slideUp(animationSpeed, function() {
                checkElement.removeClass('open');
            });
            checkElement.parent("li").removeClass("is-expanded");
        } else if ((checkElement.is(slideMenuSelector)) && (!checkElement.is(':visible'))) {
            var parent = $this.parents('ul').first();
            var ul = parent.find('ul:visible').slideUp(animationSpeed);
            ul.removeClass('open');
            var parent_li = $this.parent("li");
            checkElement.slideDown(animationSpeed, function() {
                checkElement.addClass('open');
                parent.find('li.is-expanded').removeClass('is-expanded');
                parent_li.addClass('is-expanded');
            });
        }
        if (checkElement.is(slideMenuSelector)) {
            e.preventDefault();
        }
    });

    // Activate sidebar slide toggle
    $("[data-bs-toggle='sub-slide']").on('click', function(e) {
        var $this = $(this);
        var checkElement = $this.next();
        var animationSpeed = 300,
            slideMenuSelector = '.sub-slide-menu';
        if (checkElement.is(slideMenuSelector) && checkElement.is(':visible')) {
            checkElement.slideUp(animationSpeed, function() {
                checkElement.removeClass('open');
            });
            checkElement.parent("li").addClass("is-expanded");
        } else if ((checkElement.is(slideMenuSelector)) && (!checkElement.is(':visible'))) {
            var parent = $this.parents('ul').first();
            var ul = parent.find('ul:visible').slideUp(animationSpeed);
            ul.removeClass('open');
            var parent_li = $this.parent("li");
            checkElement.slideDown(animationSpeed, function() {
                checkElement.addClass('open');
                parent.find('li.is-expanded').addClass('is-expanded');
                parent_li.removeClass('is-expanded');
            });
        }
        if (checkElement.is(slideMenuSelector)) {
            e.preventDefault();
        }
    });

    // Activate sidebar slide toggle
    $("[data-bs-toggle='sub-slide2']").on('click', function(e) {
        var $this = $(this);
        var checkElement = $this.next();
        var animationSpeed = 300,
            slideMenuSelector = '.sub-slide-menu2';
        if (checkElement.is(slideMenuSelector) && checkElement.is(':visible')) {
            checkElement.slideUp(animationSpeed, function() {
                checkElement.removeClass('open');
            });
            checkElement.parent("li").removeClass("is-expanded");
        } else if ((checkElement.is(slideMenuSelector)) && (!checkElement.is(':visible'))) {
            var parent = $this.parents('ul').first();
            var ul = parent.find('ul:visible').slideUp(animationSpeed);
            ul.removeClass('open');
            var parent_li = $this.parent("li");
            checkElement.slideDown(animationSpeed, function() {
                checkElement.addClass('open');
                parent.find('li.is-expanded').removeClass('is-expanded');
                parent_li.addClass('is-expanded');
            });
        }
        if (checkElement.is(slideMenuSelector)) {
            e.preventDefault();
        }
    });

    // ______________Active Class
    $(".app-sidebar li a").each(function() {
        var pageUrl = window.location.href.split(/[?#]/)[0];
        if (this.href == pageUrl) {
            $(this).addClass("active");
            $(this).parent().addClass("active"); // add active to li of the current link
            $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
            $(this).parent().parent().prev().click(); // click the item to make it drop
        }
    });


})();