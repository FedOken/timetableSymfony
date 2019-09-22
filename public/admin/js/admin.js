$(function() {
    //By university
    onLoadPage($('#cabinet_university'), $('#cabinet_building'), '#select2-cabinet_university-container', ajaxGetBuildingByUniversity);
    onLoadPage($('#party_university'), $('#party_course'), '#select2-party_university-container', ajaxGetCourseByUniversity);
    onLoadPage($('#schedule_university'), $('#schedule_building'), '#select2-schedule_university-container', ajaxGetBuildingByUniversity);
    onLoadPage($('#schedule_university'), $('#schedule_party'), '#select2-schedule_university-container', ajaxGetGroupByUniversity);
    onLoadPage($('#schedule_university'), $('#schedule_teacher'), '#select2-schedule_university-container', ajaxGetTeacherByUniversity);

    //By faculty
    onLoadPage($('#party_university'), $('#party_faculty'), '#select2-party_university-container', ajaxGetFacultyByUniversity);

    //By building
    onLoadPage($('#schedule_building'), $('#schedule_cabinet'), '#select2-schedule_building-container', ajaxGetCabinetByBuilding);
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

function ajaxGetBuildingByUniversity(id, select) {
    let selectedValue = select.find('option[selected="selected"]').val();
    $.ajax({
        url: '/public/index.php/ajax/get-building-by-university?university_id=' + id,
        type: 'GET',
        success: function(response){
            replaceSelectOption(select, response);
            if (selectedValue) {
                select.find('option[value="'+ selectedValue +'"]').attr('selected', 'selected')
            }
        },
        error: function(exception) {
            console.log(exception);
        }
    });
}

function ajaxGetFacultyByUniversity(id, select) {
    let selectedValue = select.find('option[selected="selected"]').val();
    $.ajax({
        url: '/public/index.php/ajax/get-faculty-by-university?university_id=' + id,
        type: 'GET',
        success: function(response){
            replaceSelectOption(select, response);
            if (selectedValue) {
                select.find('option[value="'+ selectedValue +'"]').attr('selected', 'selected')
            }
        },
        error: function(exception) {
            console.log(exception);
        }
    });
}

function ajaxGetCourseByUniversity(id, select) {
    let selectedValue = select.find('option[selected="selected"]').val();
    $.ajax({
        url: '/public/index.php/ajax/get-course-by-university?university_id=' + id,
        type: 'GET',
        success: function(response){
            replaceSelectOption(select, response);
            if (selectedValue) {
                select.find('option[value="'+ selectedValue +'"]').attr('selected', 'selected')
            }
        },
        error: function(exception) {
            console.log(exception);
        }
    });
}

function ajaxGetGroupByUniversity(id, select) {
    let selectedValue = select.find('option[selected="selected"]').val();
    $.ajax({
        url: '/public/index.php/ajax/get-group-by-university?university_id=' + id,
        type: 'GET',
        success: function(response){
            replaceSelectOption(select, response);
            if (selectedValue) {
                select.find('option[value="'+ selectedValue +'"]').attr('selected', 'selected')
            }
        },
        error: function(exception) {
            console.log(exception);
        }
    });
}

function ajaxGetTeacherByUniversity(id, select) {
    let selectedValue = select.find('option[selected="selected"]').val();
    $.ajax({
        url: '/public/index.php/ajax/get-teacher-by-university?university_id=' + id,
        type: 'GET',
        success: function(response){
            replaceSelectOption(select, response);
            if (selectedValue) {
                select.find('option[value="'+ selectedValue +'"]').attr('selected', 'selected')
            }
        },
        error: function(exception) {
            console.log(exception);
        }
    });
}

function ajaxGetCabinetByBuilding(id, select) {
    let selectedValue = select.find('option[selected="selected"]').val();
    $.ajax({
        url: '/public/index.php/ajax/get-cabinet-by-building?building_id=' + id,
        type: 'GET',
        success: function(response){
            replaceSelectOption(select, response);
            if (selectedValue) {
                select.find('option[value="'+ selectedValue +'"]').attr('selected', 'selected')
            }
        },
        error: function(exception) {
            console.log(exception);
        }
    });
}

function replaceSelectOption(select_object, data) {
    select_object.find('option').remove();
    $.each(data, function (key, value) {
        select_object.append($('<option>', {
            value: key,
            text: value
        }));
    });
}


function onLoadPage(parentSelect, childSelect, observer, functionAjax) {
    //Check for element exist
    if (!parentSelect.length || !parentSelect.length) {
        return false;
    }

    // //ON LOAD PAGE SEND REQUEST
    // //Get selected parent id, if selected, request not send
    // let university_id = parentSelect.find('option[selected="selected"]').val();
    // //Else get first id, send request
    // if (!$.isNumeric(university_id)) {
    //     university_id = parentSelect.find('option').val();
    // }
    // functionAjax(university_id, childSelect);

    //CREATE OBSERVER
    let observerElement = document.querySelector(observer);
    if (observerElement) {
        creatObserver(observerElement, parentSelect, functionAjax, childSelect);
    }
}

