<div class="btn-group d-flex gap-2">

    <a href="#" class="btn btn-primary btn-sm show-admit-card"
    data-student-id="{{ $student->student_id }}"
     data-admit-card-id="{{ $admit_card_id }}"
        data-examination-id="{{ $examination_id }}"> <i class="fa fa-eye"></i></a>

    <a href="#" class="btn btn-primary btn-sm  download-admit-card"
    data-student-id="{{ $student->student_id}}"
    data-admit-card-id="{{ $admit_card_id}}"
    data-examination-id="{{ $examination_id}}"
    target="_blank"
    ><i class="fa fa-download"></i></a>
</div>
