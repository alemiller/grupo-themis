//function fill_subscription_wrap(subscriptions) {
//
//    $("#user_subscriptions").html('');
//    if (subscriptions.length == 0) {
//
//        data = '<div class="form-group col-md-12" style="margin: 0px 0 15px 0;"> No subscriptions for user </div>';
//    } else {
//
//        data = set_subscription_data(subscriptions);
//    }
//
//    $('#user_subscriptions').append(data);
//}
//
//function fill_event_wrap(events) {
//
//    $("#user_events").html('');
//    if (events.length == 0) {
//
//        data = '<div class="form-group col-md-12" style="margin: 0px 0 15px 0;"> No events for user </div>';
//    } else {
//
//        data = set_user_event_data(events);
//    }
//
//    $('#user_events').append(data);
//}
//
//function set_subscription_data(subscriptions) {
//
//    for (x = 0; x < subscriptions.length; x++) {
//
//        var subscription = subscriptions[x];
//        var data = '<div class="form-group col-md-12" style="margin: 0px 0 15px 0;">' +
//                '   <div>' +
//                '       <div class="user_subscription_title">' + subscription.title + ':' + '</div>' +
//                '       <div class="user_subscription_startdate_label">Start:  </div>' +
//                '       <div class="user_subscription_startdate_value">' + format_date(subscription.contractStartDate) + '</div>' +
//                '   </div>' +
//                '   <div>' +
//                '       <div class="user_subscription_enddate_label">End: </div>' +
//                '       <div class="user_subscription_enddate_value">' + format_date(subscription.contractEndDate) + '</div>' +
//                '   </div>  ' +
//                '   <div>' +
//                '       <div class="user_subscription_active_label">Active: </div>' +
//                '       <div class="user_subscription_active_value">' + subscription.active + '</div>' +
//                '   </div>' +
//                '</div>';
//
//        var separator = (x == subscriptions.lenght - 1) ? " " : '<hr class="user_subscriptions_separator">';
//        data += separator;
//    }
//    return data;
//}
//
//function set_user_event_data(events) {
//    var data = '';
//    for (x = 0; x < events.length; x++) {
//
//        data += '<div class="form-group col-md-12" style="margin: 0px 0 15px 0;">' +
//                '   <div>' +
//                '       <div class="user_event_title">' + events[x].title + ':' + '</div>' +
//                '       <div class="user_event_purchased_label"> Purchased:  </div>' +
//                '       <div class="user_event_purchased_value">' + events[x].added.slice(0, 10) + '</div>' +
//                '   </div>' +
//                '</div>';
//
//        var separator = (x == events.length - 1) ? " " : '<hr class="user_events_separator">';
//        data += separator;
//    }
//    return data;
//}
//
//function set_user_data(id) {
//
//    $.ajax({
//        url: base_url + 'index.php/' + page + '/get_user_by_id',
//        type: 'POST',
//        dataType: 'json',
//        data: 'id=' + id,
//        success: function (data) {
//
//            if (data.result.status == 'error') {
//
//                $('.profile').html('');
//            } else {
//
//                user_profile = data.user_profile.content;
//                user_subscriptions = data.user_contracts.content.entries;
//                user_events = data.user_events;
//
//                if (user_profile != null && user_profile._id == id) {
//
//                    // set user profile info
//                    $('#username').val(user_profile.username);
//                    $('#userId').val(user_profile._id);
//                    $('#fullname').val(user_profile.displayName);
//                    $('#email').val(user_profile.email);
//                    $('#info_item_title').html('');
//                    if (user_profile.username.length > 20) {
//
//                        $('#info_item_title').append(user_profile.username.substring(0, 17) + '...');
//                    } else {
//                        $('#info_item_title').append(user_profile.username);
//                    }
//                    // enable change-password button in change password tab
//                    $('#footer_buttons_change_password').children('button').removeAttr('disabled');
//                }
//
//                fill_subscription_wrap(user_subscriptions);
//                fill_event_wrap(user_events);
//
//                $('.free_subscriptions').prop('disabled', false);
//
//            }
//        }
//    });
//}
//
