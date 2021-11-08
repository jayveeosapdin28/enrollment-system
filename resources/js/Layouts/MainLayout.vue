<template>
    <v-app id="inspire">
        <v-navigation-drawer
            v-model="drawer"
            app
        >
            <template v-slot:prepend>
                <v-list-item two-line>
                    <v-list-item-avatar>
                        <v-avatar
                            color="green"
                            size="45"
                        >
                            <span class="white--text">{{ nameInitials($page.props.user.name) }}</span>
                        </v-avatar>
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-title> {{ $page.props.user.name }}</v-list-item-title>
                        <v-list-item-subtitle>{{ $page.props.role[0] }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </template>
            <v-list nav dense>
                <div v-for="(link, i) in links" :key="i">
                    <v-list-item
                        v-if="!link.subLinks && (link.role ? $role(link.role) : true)"
                        :href="route(link.to)"
                        avatar
                        class="v-list-item"
                    >
                        <v-list-item-icon>
                            <v-icon>{{ link.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-title v-text="link.text" />
                    </v-list-item>

                    <v-list-group
                        v-else-if="link.subLinks && (link.role ? $role(link.role) : true)"
                        :key="link.text"
                        no-action
                        :prepend-icon="link.icon"
                        :value="false"
                    >
                        <template v-slot:activator>
                            <v-list-item-title>{{ link.text }}</v-list-item-title>
                        </template>

                        <v-list-item
                            v-for="sublink in link.subLinks"
                            :href="route(sublink.to)"
                            v-if="sublink.role ? $role(sublink.role) : true"
                            :key="sublink.text"
                        >
                            <v-list-item-icon>
                                <v-icon>{{ sublink.icon }}</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>{{ sublink.text }}</v-list-item-title>

                        </v-list-item>

                    </v-list-group>
                </div>
                <v-list-item
                    @click="logout"
                >
                    <v-list-item-icon>
                        <v-icon>mdi-shield-account</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar color="blue" dark flat app>

            <v-app-bar-nav-icon @click="drawer = !drawer">

            </v-app-bar-nav-icon>

            <v-toolbar-title>Mindoro State University</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-app-bar>

        <v-main>
            <v-container
                fluid
            >
                <slot></slot>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    name: "MainLayout",
    props: ['app'],
    data: () => ({
        drawer: null,
        // items: [
        //     //ADMIN
        //     { title: 'Pending', icon: 'mdi-file-alert', role:'Registrar', path: 'admin.enrollment-applications.pending.index' },
        //     { title: 'On Process', icon: 'mdi-file-move', role:'Registrar', path: 'admin.enrollment-applications.registrations.on-process' },
        //     { title: 'Pending', icon: 'mdi-file-alert', role:'Accounting', path: 'admin.enrollment-applications.assessments.pending' },
        //     { title: 'Processed', icon: 'mdi-file-move', role:'Accounting', path: 'admin.enrollment-applications.assessments.processed' },
        //     // { title: 'Qualified', icon: 'mdi-account', path: 'admin.enrollment-applications.qualifiers' },
        //     //STUDENT
        //     { title: 'Profile', icon: 'mdi-account', role:'Student', path: 'student.profile.index' },
        //     // { title: 'Academics', icon: 'mdi-book-open-variant', path: 'student.academics.index' },
        //     { title: 'Medical Record', icon: 'mdi-medical-bag',role:'Student', path: 'student.medical-record.index' },
        //     // { title: 'Scholarships', icon: 'mdi-file-check',path: 'student.scholarship.index' },
        //     { title: 'Enrollment Application', icon: 'mdi-file-document', role:'Student', path: 'student.enrollment.index' },
        //     // { title: 'Downloadables', icon: 'mdi-folder-download', path: 'student.profile.index' },
        //     { title: 'My Account', icon: 'mdi-account-box', path: 'profile.show' },
        // ],
        links: [
            {
                to     : 'dashboard',
                icon   : 'mdi-view-dashboard',
                text   : 'Dashboard',
            },
            {
                icon     : 'mdi-clipboard-edit',
                text     : 'Application',
                role     : 'Admin',
                subLinks : [
                    {
                        text : 'Issue ID Number',
                        to    : 'admin.enrollment-applications.registrations.issue-id',
                        icon  : 'mdi-file-alert'
                    },
                ]
            },
            {
                icon     : 'mdi-clipboard-edit',
                text     : 'Enrollments',
                role     : 'Registrar',
                subLinks : [
                    {
                        text : 'Pending',
                        to    : 'admin.enrollment-applications.registrations.pending',
                        icon  : 'mdi-file-alert'
                    },
                    {
                        text : 'On Process',
                        to    : 'admin.enrollment-applications.registrations.on-process',
                        icon  : 'mdi-file-move'
                    },
                    {
                        text : 'To Confirm',
                        to    : 'admin.enrollment-applications.registrations.to-confirm',
                        icon  : 'mdi-file-check-outline'
                    },
                    {
                        text : 'Enrolled',
                        to    : 'admin.enrollment-applications.registrations.complete',
                        icon  : 'mdi-file-check'
                    },
                ]
            },
            {
                icon     : 'mdi-account',
                text     : 'Students',
                role     : 'Clinic',
                subLinks : [
                    {
                        text : 'Medical Records',
                        to    : 'admin.enrollment-applications.registrations.medical-record',
                        icon  : 'mdi-medical-bag'
                    },
                ]
            },
            {
                icon     : 'mdi-google-spreadsheet',
                text     : 'Assessment',
                role     : 'Accounting',
                subLinks : [
                    {
                        text : 'Pending',
                        to    : 'admin.enrollment-applications.assessments.pending',
                        icon  : 'mdi-file-alert'
                    },
                    {
                        text : 'Assessed',
                        to    : 'admin.enrollment-applications.assessments.processed',
                        icon  : 'mdi-file-move'
                    },
                ]
            },
            {
                to     : 'student.profile.index',
                icon   : 'mdi-account',
                text   : 'Profile',
                role   : 'Student',
            },
            {
                to     : 'student.medical-record.index',
                icon   : 'mdi-medical-bag',
                text   : 'Medical Record',
                role   : 'Student',
            },
            {
                to     : 'student.enrollment.index',
                icon   : 'mdi-file-document',
                text   : 'Enrollment Application',
                role   : 'Student',
            },
            {
                to     : 'profile.show',
                icon   : 'mdi-account-box',
                text   : 'My Account',
            },
        ]
    }),
    computed:{
        errors() {
            return this.$page.props.errors
        },
    },
    watch:{
      errors(newValue ,oldValue){
          if (newValue){
              console.log(newValue);
          }
      },
    },
    methods:{
        nameInitials(user) {
            const name = user.split(' ')
            return `${name[0].charAt(0)}${name[1] ? name[1].charAt(0) : ''}`;
        },
        logout() {
            this.$inertia.post(route('logout'));
        },
    }
}
</script>

<style scoped>

</style>
