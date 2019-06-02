<template>
    <div>
        <div class="row justify-content-center" v-show="loading">
            <div class="col-md-8">
                <div class="text-center">
                    <div class="spinner-grow" style="width: 4rem; height: 4rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <strong>Last Links</strong>
                    </div>
                    <ul class="list-group list-group-flush">
                        <a :href="link.domain + link.code" class="list-group-item list-group-item-action" v-for="link in lastLinks">
                            <div class="row">
                                <div class="col-6"><span data-toggle="tooltip" data-placement="top" title="URL">{{ link.url }}</span></div>
                                <div class="col-4"><span data-toggle="tooltip" data-placement="top" title="Code">{{ link.code }}</span></div>
                                <div class="col-2"><span class="badge badge-primary badge-pill" data-toggle="tooltip" data-placement="top" title="Visits">{{ link.visits.length }}</span></div>
                            </div>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row mt-3">
                    <div class="col">
                        <div class="card text-white bg-success mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Users</h5>
                                <p class="card-text">
                                    {{ total_users}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-white bg-danger mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Links</h5>
                                <p class="card-text">{{ total_links }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-white bg-dark mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Visits</h5>
                                <p class="card-text">{{ total_visits }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LastLinksComponent",
        data() {
            return {
                loading: false,
                lastLinks: [],
                total_visits: 0,
                total_links: 0,
                total_users: 0
            }
        },

        mounted() {
            var self = this;
            axios.get('last-links').then(function(response) {
                self.lastLinks = response.data;
                Vue.nextTick(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            }).catch(function (error) {
                console.log(error);
            });
            axios.get('statistics').then(function(response) {
                self.total_visits = response.data.total_visits;
                self.total_links = response.data.total_links;
                self.total_users = response.data.total_users;
                self.loading = false;
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
</script>

<style scoped>

</style>