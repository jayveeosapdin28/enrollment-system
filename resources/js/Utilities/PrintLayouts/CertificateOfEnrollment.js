import jsPDF from 'jspdf'
import {getYearLevel,getSem,toTitleCase} from "../Helper";

function printCOR(student, subjects,schoolInfo) {
    var doc = new jsPDF('p', 'in', 'A4'); //A4
    var academic_year= student.cureffec;
    var copies = ["Student's Copy","Accounting's Copy","Registrar's Copy"];

    doc.setFont('times');
    doc.setFontStyle("normal");
    doc.setFontSize(8.5);
    doc.setFontStyle("italic");
    doc.setFontSize(11);

    doc.text("Student's Copy", 7.8, .88, null, null, 'right');

    doc.setFontStyle("bold");
    doc.setFontSize(11);
    doc.setTextColor(0, 65, 0);
    doc.text(schoolInfo.name, 4.2, .42, null, null, 'center');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle("normal");
    doc.text(schoolInfo.adddress, 4.2, .60, null, null, 'center');
    doc.setFontStyle("bold");

    doc.text('ENROLLMENT FORM', 4.2, .88, null, null, 'center');
    doc.setFontStyle("italic");

    doc.setFontSize(11);
    doc.setFontStyle("normal");
    doc.text('ID Number: ' + student.idnumber, .3, 1.14, null, null, 'left');

    doc.text('Full Name: ' + toTitleCase(student.user.name), .3, 1.30, null, null, 'left');
    doc.text('Program: ' + student.program.corcode + (!student.program.cormajor === 'NONE' ? toTitleCase(student.program.cormajor) : ''), 4, 1.14, null, null, 'left');
    doc.text('Year & Section : '+ toTitleCase(getYearLevel(student.yearlevel)), 6, 1.14, null, null, 'left');
    doc.text('Semester : '+toTitleCase(getSem(student.studsem)), 6, 1.30, null, null, 'left');
    doc.text('A.Y.:  ' + academic_year, 4, 1.30, null, null, 'left');


    doc.setLineWidth(0.01)
    doc.setDrawColor(0, 0, 0);
    //doc.setLineDash([.5])
    //side
    doc.line(.3, 1.4, .3, 3.41)
    doc.line(8, 1.4, 8, 3.60)

    doc.line(.3, 1.4, 8, 1.4)

    doc.setFontStyle("bold");
    doc.text(.4, 1.55, "Course Code");
    doc.text(2, 1.55, "Course Description");
    doc.text(5.6, 1.55, "Unit/s");
    doc.text(6.89, 1.55, "Status");
    doc.line(.3, 1.6, 8, 1.6);

    var $pos = 1.6;
    var unit = 0;
    var subject = 0;
    subjects.forEach(function (item) {
        $pos = $pos + .16
        doc.setFontStyle("normal");
        doc.text(.4, $pos, ''+item.subject.subcode);
        doc.text(1.5, $pos, ''+item.subject.subdesc);
        doc.text(5.8, $pos, ''+item.subject.subunit);
        if(item.status === 'DROPPED')
            doc.setTextColor(200, 0, 0);
        if(item.status === 'ENROLLED')
            doc.setTextColor(0, 150, 0);
        doc.text(6.8, $pos, toTitleCase(item.status));
        subject += (item.status == 'ENROLLED'? 1 : 0);
        unit += parseInt(item.status == 'ENROLLED'? ''+item.subject.subunit : 0)
        doc.setTextColor(0, 0, 0);
    })

    doc.line(.3, 3.41, 8, 3.41)

    doc.setFontStyle("bold");
    doc.text('Enrolled Unit/s: '+unit, 6.5, 3.54, null, null, 'left');
    doc.text('Enrolled Subject/s: '+subject, 4.8, 3.54, null, null, 'left');
    doc.setFontStyle("normal");
    unit = 0;
    subject = 0;
    doc.line(4.3, 3.60, 8, 3.60)
    doc.line(4.3, 3.60, 3.6, 3.41)


    doc.line(.3, 3.7, 1.8, 3.7)
    doc.text('Campus Registrar', .5, 3.82, null, null, 'left');
    doc.line(2.3, 3.7, 3.8, 3.7)
    doc.text("Student's Signature", 2.5, 3.82, null, null, 'left');

    doc.setFontStyle("italic");
    doc.setFontSize(9);

    doc.text('*** Nothing Follows ***', 4, 3.96, null, null, 'center');
    doc.setLineWidth(0.01)
    doc.setDrawColor(0, 0, 0);
    doc.setLineDash([0.03])
    doc.line(0, 4, 9, 4)

//---------------------------------------------------Accounting Copy-------------------------------------------
    var yPos = 3.89;
    doc.setFont('times');
    doc.setFontStyle("normal");
    doc.setFontSize(8.5);
    doc.setFontStyle("italic");
    doc.setFontSize(11);

    doc.text("Accounting's Copy", 7.8, .88 + yPos, null, null, 'right');

    doc.setFontStyle("bold");
    doc.setFontSize(11);
    doc.setTextColor(0, 65, 0);
    doc.text(schoolInfo.name, 4.2, .42 + yPos, null, null, 'center');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle("normal");
    doc.text(schoolInfo.adddress, 4.2, .60 + yPos, null, null, 'center');
    doc.setFontStyle("bold");

    doc.text('ENROLLMENT FORM', 4.2, .88 + yPos, null, null, 'center');
    doc.setFontStyle("italic");

    doc.setFontSize(11);
    doc.setFontStyle("normal");
    doc.text('ID Number: ' + student.idnumber, .3, 1.14 + yPos, null, null, 'left');

    doc.text('Full Name: ' + toTitleCase(student.user.name), .3, 1.30 + yPos, null, null, 'left');
    doc.text('Program: ' + student.program.corcode + (!student.program.cormajor === 'NONE' ? toTitleCase(student.program.cormajor) : ''), 4, 1.14 + yPos, null, null, 'left');
    doc.text('Year & Section : '+ toTitleCase(getYearLevel(student.yearlevel)), 6, 1.14 + yPos, null, null, 'left');
    doc.text('Semester : '+toTitleCase(getSem(student.studsem)), 6, 1.30 + yPos, null, null, 'left');
    doc.text('A.Y.:  ' + academic_year, 4, 1.30 + yPos, null, null, 'left');


    doc.setLineWidth(0.01);
    doc.setDrawColor(0, 0, 0);
    doc.setLineDash(0);
    //side
    doc.line(.3, 1.4 + yPos, .3, 3.41 + yPos)
    doc.line(8, 1.4 + yPos, 8, 3.60 + yPos)

    doc.line(.3, 1.4 + yPos, 8, 1.4 + yPos)

    doc.setFontStyle("bold");
    doc.text(.4, 1.55 + yPos, "Course Code");
    doc.text(2, 1.55 + yPos, "Course Description");
    doc.text(5.6, 1.55 + yPos, "Unit/s");
    doc.text(6.89, 1.55 + yPos, "Status");
    doc.line(.3, 1.6 + yPos, 8, 1.6 + yPos);

    var $pos = (1.6 + yPos);
    var unit = 0;
    var subject = 0;
    subjects.forEach(function (item) {
        $pos = $pos + .16
        doc.setFontStyle("normal");
        doc.text(.4, $pos, ''+item.subject.subcode);
        doc.text(1.5, $pos, ''+item.subject.subdesc);
        doc.text(5.8, $pos, ''+item.subject.subunit);
        if(item.status === 'DROPPED')
            doc.setTextColor(200, 0, 0);
        if(item.status === 'ENROLLED')
            doc.setTextColor(0, 150, 0);
        doc.text(6.8, $pos, toTitleCase(item.status));
        subject += item.status == 'ENROLLED'? 1 : 0;
        unit += parseInt(''+item.status == 'ENROLLED'? ''+item.subject.subunit : 0)
        doc.setTextColor(0, 0, 0);
    })

    doc.line(.3, 3.41 + yPos, 8, 3.41 + yPos)

    doc.setFontStyle("bold");
    doc.text('Enrolled Units: '+unit, 6.5, 3.54 + yPos, null, null, 'left');
    doc.text('Enrolled Subjects: '+subject, 4.8, 3.54 + yPos, null, null, 'left');
    doc.setFontStyle("normal");
    unit = 0;
    subject = 0;
    doc.line(4.3, 3.60 + yPos, 8, 3.60 + yPos)
    doc.line(4.3, 3.60 + yPos, 3.6, 3.41 + yPos)

    doc.line(.3, 3.7 + yPos, 1.8, 3.7 + yPos)
    doc.text('Campus Registrar', .5, 3.82+ yPos, null, null, 'left');
    doc.line(2.3, 3.7 + yPos, 3.8, 3.7 + yPos)
    doc.text("Student's Signature", 2.5, 3.82 + yPos, null, null, 'left');

    doc.setFontStyle("italic");
    doc.setFontSize(9);

    doc.text('*** Nothing Follows ***', 4, 3.96 + yPos, null, null, 'center');
    doc.setLineWidth(0.01)
    doc.setDrawColor(0, 0, 0);
    doc.setLineDash([0.03])
    doc.line(0, 4 + yPos, 9, 4 + yPos)

 //-------------------------------------------------------registrar copy------
    yPos = 7.78;
    doc.setFont('times');
    doc.setFontStyle("normal");
    doc.setFontSize(8.5);
    doc.setFontStyle("italic");
    doc.setFontSize(11);

    doc.text("Registrar's Copy", 7.8, .88 + yPos, null, null, 'right');

    doc.setFontStyle("bold");
    doc.setFontSize(11);
    doc.setTextColor(0, 65, 0);
    doc.text(schoolInfo.name, 4.2, .42 + yPos, null, null, 'center');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle("normal");
    doc.text(schoolInfo.adddress, 4.2, .60 + yPos, null, null, 'center');
    doc.setFontStyle("bold");

    doc.text('ENROLLMENT FORM', 4.2, .88 + yPos, null, null, 'center');
    doc.setFontStyle("italic");

    doc.setFontSize(11);
    doc.setFontStyle("normal");
    doc.text('ID Number: ' + student.idnumber, .3, 1.14 + yPos, null, null, 'left');

    doc.text('Full Name: ' + toTitleCase(student.user.name), .3, 1.30 + yPos, null, null, 'left');
    doc.text('Program: ' + student.program.corcode + (!student.program.cormajor === 'NONE' ? toTitleCase(student.program.cormajor) : ''), 4, 1.14 + yPos, null, null, 'left');
    doc.text('Year & Section : '+ toTitleCase(getYearLevel(student.yearlevel)), 6, 1.14 + yPos, null, null, 'left');
    doc.text('Semester : '+toTitleCase(getSem(student.studsem)), 6, 1.30 + yPos, null, null, 'left');
    doc.text('A.Y.:  ' + academic_year, 4, 1.30 + yPos, null, null, 'left');


    doc.setLineWidth(0.01);
    doc.setDrawColor(0, 0, 0);
    doc.setLineDash(0);
    //side
    doc.line(.3, 1.4 + yPos, .3, 3.41 + yPos)
    doc.line(8, 1.4 + yPos, 8, 3.60 + yPos)

    doc.line(.3, 1.4 + yPos, 8, 1.4 + yPos)

    doc.setFontStyle("bold");
    doc.text(.4, 1.55 + yPos, "Course Code");
    doc.text(2, 1.55 + yPos, "Course Description");
    doc.text(5.6, 1.55 + yPos, "Unit/s");
    doc.text(6.89, 1.55 + yPos, "Status");
    doc.line(.3, 1.6 + yPos, 8, 1.6 + yPos);

    var $pos = (1.6 + yPos);
    var unit = 0;
    var subject = 0;
    subjects.forEach(function (item) {
        $pos = $pos + .16
        doc.setFontStyle("normal");
        doc.text(.4, $pos, ''+item.subject.subcode);
        doc.text(1.5, $pos, ''+item.subject.subdesc);
        doc.text(5.8, $pos, ''+item.subject.subunit);
        if(item.status === 'DROPPED')
            doc.setTextColor(200, 0, 0);
        if(item.status === 'ENROLLED')
            doc.setTextColor(0, 150, 0);
        doc.text(6.8, $pos, toTitleCase(item.status));
        subject += item.status == 'ENROLLED'? 1 : 0;
        unit += parseInt(''+item.status == 'ENROLLED'? ''+item.subject.subunit : 0)
        doc.setTextColor(0, 0, 0);
    })

    doc.line(.3, 3.41 + yPos, 8, 3.41 + yPos)

    doc.setFontStyle("bold");
    doc.text('Enrolled Units: '+unit, 6.5, 3.54 + yPos, null, null, 'left');
    doc.text('Enrolled Subjects: '+subject, 4.8, 3.54 + yPos, null, null, 'left');
    doc.setFontStyle("normal");
    unit = 0;
    subject = 0;
    doc.line(4.3, 3.60 + yPos, 8, 3.60 + yPos)
    doc.line(4.3, 3.60 + yPos, 3.6, 3.41 + yPos)

    doc.line(.3, 3.7 + yPos, 1.8, 3.7 + yPos)
    doc.text('Campus Registrar', .5, 3.82 + yPos, null, null, 'left');
    doc.line(2.3, 3.7 + yPos, 3.8, 3.7 + yPos)
    doc.text("Student's Signature", 2.5, 3.82 + yPos, null, null, 'left');

    doc.setFontStyle("italic");
    doc.setFontSize(9);


    //---------------------------------------------------------------------------------------------------------------
    doc.setProperties({
        title: toTitleCase(student.user.name)+'_'+student.idnumber+'_REGISTRATION_FORM',
        subject: 'Registration Form',
        author: 'MinSU Enrollment',
        keywords: 'generated, Registration, Form, MinSU, Enrollment',
        creator: 'MinSU'
    });

    window.open(doc.output('bloburl'), '_blank');
}

export {printCOR}
