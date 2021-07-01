<template>
    <v-list dense>
        <v-list-tile exact to="/admin">
            <v-list-tile-action>
                <v-icon>dashboard</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Dashboard</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>

        <v-list-group v-if="$auth.isAdmin()" no-action>
            <v-list-tile slot="activator">
                <v-list-tile-action>
                    <v-icon>account_circle</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>User Management</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile to="/admin/users">
                <v-list-tile-action>
                    <v-icon>account_circle</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Users</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile to="/admin/students">
                <v-list-tile-action>
                    <v-icon>account_circle</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Students</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <!-- <v-list-tile to="/admin/roles">
        <v-list-tile-action>
          <v-icon>account_circle</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Roles</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-tile to="/admin/permissions">
        <v-list-tile-action>
          <v-icon>account_circle</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Permissions</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile> -->
        </v-list-group>

        <v-list-tile to="/admin/quiz">
            <v-list-tile-action>
                <svg style="width:22px;height:24px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M13 3C16.9 3 20 6.1 20 10C20 12.8 18.4 15.2 16 16.3V21H9V18H8C6.9 18 6 17.1 6 16V13H4.5C4.1 13 3.8 12.5 4.1 12.2L6 9.7C6.2 5.9 9.2 3 13 3M13 1C8.4 1 4.6 4.4 4.1 8.9L2.5 11C1.9 11.8 1.9 12.8 2.3 13.6C2.7 14.3 3.3 14.8 4 14.9V16C4 17.9 5.3 19.4 7 19.9V23H18V17.5C20.5 15.8 22 13.1 22 10C22 5 18 1 13 1M14 14H12V13H14V14M15.6 9.5C15.3 9.9 15 10.3 14.5 10.6V12H11.5V10.6C10.1 9.8 9.6 7.9 10.4 6.5S13.1 4.6 14.5 5.4 16.4 8.1 15.6 9.5Z" />
                </svg>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Quiz</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>

        <v-list-tile to="/admin/activities">
            <v-list-tile-action>
                <v-icon>settings</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Activities</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>

        <v-list-tile to="/admin/settings">
            <v-list-tile-action>
                <v-icon>settings</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Settings</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
    </v-list>
</template>

<script>
export default {};
</script>
