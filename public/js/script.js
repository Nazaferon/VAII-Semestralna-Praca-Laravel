$(document).ready(function() {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    $('#back-to-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 0);
    });

    $('#flash-message').show().fadeOut(7000);

    $(document).on('submit', 'form[data-confirm]', function(e){
        if(!confirm($(this).data('confirm'))){
            e.stopImmediatePropagation();
            e.preventDefault();
        }
    });

    function pageLinkNumber() {
        var newPage = $(this).data("page-number");
        changeItems(newPage);
    }

    function pageLinkNext() {
        event.preventDefault();
        Paginator.setCurrentPage(Paginator.currentPage() + 1);
        console.log("ok");
    }

    function pageLinkPrevious() {
        changeItems(--currentPage);
    }

    function changeItems($newPageNumber) {
        $('.items li').addClass('hideme');
        var startItem = ($newPageNumber - 1) * 10 +1;
        var endItem = $newPageNumber * 10 +1;
        for (var item = startItem; item < endItem; item++) {
            $(".items li:nth-of-type(" + item + ")").removeClass('hideme');
        }
        currentPage = $newPageNumber;
    }
});

function sieveItems() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var min_price = $("#min_price").val();
    var max_price = $("#max_price").val();
    var available = (document.getElementById("available").checked);
    var newer = (document.getElementById("newer").checked);
    if ($("#most-popular").hasClass("active")) {
        var sorter = "most-popular";
    }
    else if ($("#most-expensive").hasClass("active")) {
        var sorter = "most-expensive";
    }
    else if ($("#less-expensive").hasClass("active")) {
        var sorter = "less-expensive";
    }
    $.ajax({
        type: "post",
        url: "/items/sieve",
        data: {
            "min_price": min_price,
            "max_price": max_price,
            "available": available,
            "newer": newer,
            "sorter": sorter
        },
        dataType: 'json',
        success: function(response) {
            $("#home-table").html(response);
        }
    });
}

function increaseOrderAmount(orderId, orderAmount)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (orderAmount < 100)
        orderAmount++;
    $.ajax({
        type: "post",
        url: "/shopping-basket/update/amount",
        data: {
            "orderAmount": orderAmount,
            "orderId": orderId
        },
        dataType: 'json',
        success: function(response) {
            $("#shopping-basket-table").html(response);
        }
    });
}

function reduceOrderAmount(orderId, orderAmount)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (orderAmount > 1)
        orderAmount--;
    $.ajax({
        type: "post",
        url: "/shopping-basket/update/amount",
        data: {
            "orderAmount": orderAmount,
            "orderId": orderId
        },
        dataType: 'json',
        success: function(response) {
            $("#shopping-basket-table").html(response);
        }
    });
}
