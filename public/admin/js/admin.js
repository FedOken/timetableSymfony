$(function() {
    //By university
    // onLoadPage($('#cabinet_university'), $('#cabinet_building'), '#select2-cabinet_university-container', ajaxGetBuildingByUniversity);
    // onLoadPage($('#party_university'), $('#party_course'), '#select2-party_university-container', ajaxGetCourseByUniversity);
    // onLoadPage($('#schedule_university'), $('#schedule_building'), '#select2-schedule_university-container', ajaxGetBuildingByUniversity);
    // onLoadPage($('#schedule_university'), $('#schedule_party'), '#select2-schedule_university-container', ajaxGetGroupByUniversity);
    // onLoadPage($('#schedule_university'), $('#schedule_teacher'), '#select2-schedule_university-container', ajaxGetTeacherByUniversity);
    //
    // //By faculty
    // onLoadPage($('#party_university'), $('#party_faculty'), '#select2-party_university-container', ajaxGetFacultyByUniversity);
    //
    // //By building
    // onLoadPage($('#schedule_building'), $('#schedule_cabinet'), '#select2-schedule_building-container', ajaxGetCabinetByBuilding);
});



function creatObserver(observerTarget, selectParent, ajaxRequest, selectChild) {
    //Set exception for observer loop break
    let BreakException = {};

    //Create observer
    let observer = new MutationObserver(function(mutations) {
        try {
            mutations.forEach(function(mutation) {

                if (mutation.type === 'attributes') {
                    //Get option name
                    let name = $(mutation.target).attr('title');
                    //Find name in select, get value
                    selectParent.find('option').each(function () {
                        if($(this).html() === name) {
                            //Get value and send request
                            ajaxRequest($(this).val(), selectChild);
                        }
                    });

                    //Break loop
                    let breakLoop = true;
                    if (breakLoop) throw BreakException;
                }
            });

        } catch (e) {
            if (e !== BreakException) throw e;
        }
    });

    //Observer config
    let config = { attributes: true };
    //Start observer
    observer.observe(observerTarget, config);
}








// function onLoadPage(parentSelect, childSelect, observer, functionAjax) {
//     //Check for element exist
//     if (!parentSelect.length || !parentSelect.length) {
//         return false;
//     }
//
//     // //ON LOAD PAGE SEND REQUEST
//     // //Get selected parent id, if selected, request not send
//     // let university_id = parentSelect.find('option[selected="selected"]').val();
//     // //Else get first id, send request
//     // if (!$.isNumeric(university_id)) {
//     //     university_id = parentSelect.find('option').val();
//     // }
//     // functionAjax(university_id, childSelect);
//
//     //CREATE OBSERVER
//     let observerElement = document.querySelector(observer);
//     if (observerElement) {
//         creatObserver(observerElement, parentSelect, functionAjax, childSelect);
//     }
// }



$().ready(function () {

    let schUniversity = $('#schedule_university');
    let schBuilding = $('#schedule_building');
    let schCabinet = $('#schedule_cabinet');
    let schGroup = $('#schedule_party');
    let schTeacher = $('#schedule_teacher');
    let schWeek = $('#schedule_week');
    let schTime = $('#schedule_universityTime');

    schBuilding.on('change', function () {
        ajaxGetCabinetByBuilding($(this).val(), schCabinet)
    });

    schUniversity.on('change', function () {
        ajaxGetBuildingByUniversity($(this).val(), schBuilding);
        ajaxGetGroupByUniversity($(this).val(), schGroup);
        ajaxGetTeacherByUniversity($(this).val(), schTeacher);
        ajaxGetWeekByUniversity($(this).val(), schWeek);
        ajaxGetTimeByUniversity($(this).val(), schTime);
    });

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

function ajaxGetFacultyByUniversity(id, selectToChange) {
    $.ajax({
        url: '/public/index.php/ajax/get-faculty-by-university?universityId=' + id,
        type: 'GET',
        success: function(response){
            replaceSelectOption(selectToChange, response);
        },
        error: function(exception) {
            console.log(exception);
        }
    });
}

function ajaxGetCourseByUniversity(id, selectToChange) {
    $.ajax({
        url: '/public/index.php/ajax/get-course-by-university?universityId=' + id,
        type: 'GET',
        success: function(response){
            replaceSelectOption(selectToChange, response);
        },
        error: function(exception) {
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