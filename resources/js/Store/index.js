import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)
// DASHBOARD MODULE
import DashboardIndex from './Modules/Dashboard/Index'
import DashboardSingle from './Modules/Dashboard/Single'
// PERSONAL INFORMATION MODULE
import PersonalInformationIndex from './Modules/PersonalInformation/Index'
import PersonalInformationSingle from './Modules/PersonalInformation/Single'
// CONTACT INFORMATION MODULE
import ContactInformationIndex from './Modules/ContactInformation/Index'
import ContactInformationSingle from './Modules/ContactInformation/Single'
// ADDRESS INFORMATION MODULE
import AddressInformationIndex from './Modules/AddressInformation/Index'
import AddressInformationSingle from './Modules/AddressInformation/Single'
// EDUCATIONAL BACKGROUND MODULE
import EducationalBackgroundIndex from './Modules/EducationalBackground/Index'
import EducationalBackgroundSingle from './Modules/EducationalBackground/Single'
// FAMILY INFORMATION MODULE
import FamilyInformationIndex from './Modules/FamilyInformation/Index'
import FamilyInformationSingle from './Modules/FamilyInformation/Single'
// ENROLLMENT INFORMATION  MODULE
import EnrollmentInformationIndex from './Modules/EnrollmentInformation/Index'
import EnrollmentInformationSingle from './Modules/EnrollmentInformation/Single'
// ADDTIONAL INFORMATION  MODULE
import AdditionalInformationIndex from './Modules/AdditionalInformation/Index'
import AdditionalInformationSingle from './Modules/AdditionalInformation/Single'
// ACADEMIC INFORMATION  MODULE
import AcademicInformationIndex from './Modules/AcademicInformation/Index'
import AcademicInformationSingle from './Modules/AcademicInformation/Single'
// COURSE INFORMATION  MODULE
import CourseInformationIndex from './Modules/CourseInformation/Index'
import CourseInformationSingle from './Modules/CourseInformation/Single'
// RELIGION INFORMATION  MODULE
import ReligionInformationIndex from './Modules/ReligionInformation/Index'
//ENROLLMENT HISTORY MODULE
import EnrollmentHistoryIndex from './Modules/EnrollmentHistory/Index'
//ENROLLMENT APPLICATION MODULE
import EnrollmentApplicationIndex from './Modules/EnrollmentApplication/Index'
//PENDING APPLICATION MODULE
import PendingApplicationIndex from './Modules/PendingApplication/Index'
import PendingApplicationSingle from './Modules/PendingApplication/Single'
//SUBJECT MODULE
import SubjectIndex from './Modules/Subject/Index'
import SubjectSingle from './Modules/Subject/Single'
//ENROLL SUBJECT MODULE
import EnrollSubjectIndex from './Modules/EnrollSubject/Index'
import EnrollSubjectSingle from './Modules/EnrollSubject/Single'
//ENROLLED SUBJECT MODULE
import EnrolledSubjectIndex from './Modules/EnrolledSubject/Index'
import EnrolledSubjectSingle from './Modules/EnrolledSubject/Single'
//ENROLLMENT ASSESSMENT MODULE
import StudentAssessmentIndex from './Modules/StudentAssessment/Index'
import StudentAssessmentSingle from './Modules/StudentAssessment/Single'
//ENROLLMENT ASSESSMENT MODULE
import FeeIndex from './Modules/Fee/Index'
import FeeSingle from './Modules/Fee/Single'
//ENROLLMENT REGISTRATION MODULE
import RegistrationIndex from './Modules/Registration/Index'
import RegistrationSingle from './Modules/Registration/Single'
//MEDICAL INFORMATION MODULE
import MedicalInformationIndex from './Modules/MedicalInformation/Index'
import MedicalInformationSingle from './Modules/MedicalInformation/Single'
//SIGNATURE MODULE
import SignaturePadIndex from './Modules/SignaturePad/Index'
import SignaturePadSingle from './Modules/SignaturePad/Single'
const store = new Vuex.Store({
    modules: {
        PersonalInformationIndex,
        PersonalInformationSingle,

        ContactInformationIndex,
        ContactInformationSingle,

        AddressInformationIndex,
        AddressInformationSingle,

        EducationalBackgroundIndex,
        EducationalBackgroundSingle,

        FamilyInformationIndex,
        FamilyInformationSingle,

        EnrollmentInformationIndex,
        EnrollmentInformationSingle,

        AcademicInformationIndex,
        AcademicInformationSingle,

        CourseInformationIndex,
        CourseInformationSingle,

        AdditionalInformationIndex,
        AdditionalInformationSingle,

        ReligionInformationIndex,

        EnrollmentHistoryIndex,

        EnrollmentApplicationIndex,

        PendingApplicationIndex,
        PendingApplicationSingle,

        SubjectIndex,
        SubjectSingle,

        EnrollSubjectIndex,
        EnrollSubjectSingle,

        EnrolledSubjectIndex,
        EnrolledSubjectSingle,

        StudentAssessmentIndex,
        StudentAssessmentSingle,

        FeeIndex,
        FeeSingle,

        RegistrationIndex,
        RegistrationSingle,

        DashboardSingle,
        DashboardIndex,

        MedicalInformationSingle,
        MedicalInformationIndex,

        SignaturePadIndex,
        SignaturePadSingle
    }
})
export default store;
