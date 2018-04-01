<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <h2>
                        {{searchResults.length}} results found for: <span class="text-navy">“{{searchTerm}}”</span>
                    </h2>
                    <small>Request time  (0.23 seconds)</small>


                    <div class="hr-line-dashed"></div>
                    <div class="search-result">
                        <h3><a href="#">{{searchResults}}</a></h3>
                        <a href="#" class="search-link">{{searchResults}}</a>
                        <p>
                           {{searchResults}}
                        </p>
                    </div>
                    <div class="hr-line-dashed"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "search-results",
        props : [
            'currentUser',
            'currentUserData',
            'swapComponent',
            'searchTerm',
            'searchResults'
        ],
    }
</script>

<style scoped>

</style>