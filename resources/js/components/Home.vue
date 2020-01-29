<template>
  <v-app id="home">
    <v-content>
      <v-container
        class="fill-height"
        fluid
      >
        <v-row
          align="center"
          justify="center"
        >
          <v-col
            cols="12"
            sm="8"
            md="4"
          >
            <v-card class="elevation-12">
              <v-toolbar
                color="primary"
                dark
                flat
              >
                <v-toolbar-title>Welcome To Royal Caribbean</v-toolbar-title>
                <v-spacer />
                <v-tooltip right>
                  <template v-slot:activator="{ on }">
                    <v-btn
                      icon
                      large
                      href="https://github.com/nsaenzz/RoyalCaribbean"
                      target="_blank"
                      v-on="on"
                    >
                      <v-icon>code-tags</v-icon>
                    </v-btn>
                  </template>
                  <span>Codepen</span>
                </v-tooltip>
              </v-toolbar>

              <v-card-actions>
                <v-btn class="mx-auto my-10"
                    color="yellow darken-1"
                    large
                    href="/registration">Register a New Guest</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  export default {
    props: {
      source: String,
    },
  }
</script>