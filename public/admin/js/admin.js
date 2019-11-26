$().ready(function () {

    let schUniversity = $('#schedule_university');
    let schBuilding = $('#schedule_building');
    let schCabinet = $('#schedule_cabinet');
    let schGroup = $('#schedule_party');
    let schTeacher = $('#schedule_teacher');
    let schWeek = $('#schedule_week');
    let schTime = $('#schedule_universityTime');

    //Building change
    schBuilding.on('change', function () {
        ajaxGetCabinetByBuilding($(this).val(), schCabinet)
    });

    //Event university change
    schUniversity.on('change', function () {
        ajaxGetBuildingByUniversity($(this).val(), schBuilding);
        ajaxGetGroupByUniversity($(this).val(), schGroup);
        ajaxGetTeacherByUniversity($(this).val(), schTeacher);
        ajaxGetWeekByUniversity($(this).val(), schWeek);
        ajaxGetTimeByUniversity($(this).val(), schTime);
    });

    //Language change
    $('#lang-selector').on('change', function () {
        $.ajax({
            url: '/public/index.php/ajax/set-language?_locale=' + $(this).val(),
            type: 'GET',
            success: function(response){
                if (response == true) {
                    window.location.reload();
                }
            },
            error: function(exception) {
                console.log(exception);
            }
        });
    });
});

function replaceSelectOption(select_object, data) {
    select_object.find('option').remove();
    $.each(data, function (key, value) {
        select_object.append($('<option>', {
            value: key,
            text: value
        }));
    });
}

function ajaxGetCabinetByBuilding(id, selectToChange) {
    $.ajax({
        url: '/public/index.php/ajax/get-cabinet-by-building?buildingId=' + id,
        type: 'GET',
        success: function(response){
            replaceSelectOption(selectToChange, response);
        },
        error: function(exception) {
            console.log(exception);
        }
    });
}

function ajaxGetBuildingByUniversity(id, selectToChange) {
    $.ajax({
        url: '/public/index.php/ajax/get-building-by-university?universityId=' + id,
        type: 'GET',
        success: function (response) {
            replaceSelectOption(selectToChange, response);
            $('#schedule_building').change();
        },
        error: function (exception) {
            console.log(exception);
        }
    });
}

function ajaxGetGroupByUniversity(id, selectToChange) {
    $.ajax({
        url: '/public/index.php/ajax/get-group-by-university?universityId=' + id,
        type: 'GET',
        success: function(response){
            replaceSelectOption(selectToChange, response);
        },
        error: function(exception) {
            console.log(exception);
        }
    });
}

function ajaxGetTeacherByUniversity(id, selectToChange) {
    $.ajax({
        url: '/public/index.php/ajax/get-teacher-by-university?universityId=' + id,
        type: 'GET',
        success: function(response){
            replaceSelectOption(selectToChange, response);
        },
        error: function(exception) {
            console.log(exception);
        }
    });
}

function ajaxGetWeekByUniversity(id, selectToChange) {
    $.ajax({
        url: '/public/index.php/ajax/get-week-by-university?universityId=' + id,
        type: 'GET',
        success: function(response){
            replaceSelectOption(selectToChange, response);
        },
        error: function(exception) {
            console.log(exception);
        }
    });
}

function ajaxGetTimeByUniversity(id, selectToChange) {
    $.ajax({
        url: '/public/index.php/ajax/get-time-by-university?universityId=' + id,
        type: 'GET',
        success: function(response){
            replaceSelectOption(selectToChange, response);
        },
        error: function(exception) {
            console.log(exception);
        }
    });
}