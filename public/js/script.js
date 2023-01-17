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
});

function sieveItems() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let min_price = $("#min_price").val();
    let max_price = $("#max_price").val();
    let available = (document.getElementById("available").checked);
    let newer = (document.getElementById("newer").checked);
    let sorter = "";
    if ($("#most-popular").hasClass("active")) {
        sorter = "most-popular";
    }
    else if ($("#most-expensive").hasClass("active")) {
        sorter = "most-expensive";
    }
    else if ($("#less-expensive").hasClass("active")) {
        sorter = "less-expensive";
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

function setRatingValue(new_rating_value) {
    let rating_value = document.getElementById("rating_value");
    rating_value.value = new_rating_value;

    for (let i = 1; i <= parseInt(rating_value.value); i++) {
        let star = document.getElementById("star_" + i);
        star.classList.remove("text-secondary");
        star.classList.add("text-warning");

    }
    for (let i = parseInt(rating_value.value) + 1; i <= 5; i++) {
        let star = document.getElementById("star_" + i);
        star.classList.remove("text-warning");
        star.classList.add("text-secondary");
    }
}

function showUpdateReviewForm() {
    $("#update_review_form").show();
    $("#read_review").hide();
}

function increaseOrderAmount(order_id, order_amount)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (order_amount < 100)
        order_amount++;
    $.ajax({
        type: "post",
        url: "/shopping-basket/update/amount",
        data: {
            "order_amount": order_amount,
            "order_id": order_id
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
