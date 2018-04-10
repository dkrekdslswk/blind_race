<template>
    <div>
        <button @click="start">Start</button>
        <img src="https://i.imgur.com/guhQqnS.png" width="150px">
            <img src="https://i.imgur.com/jbVKOQW.gif" width="350px">
                <b-progress
                    height="30px"
                    :value="92"
                    variant="success"
                    striped="striped"
                    :animated="animate"
                    class="mb-2 w-75 "></b-progress>

                <img src="https://i.imgur.com/KARrYZA.png" width="150px">
                    <img src="https://i.imgur.com/7zAsK3l.gif" width="300px">
                        <b-progress
                            height="30px"
                            :value="50"
                            variant="info"
                            striped="striped"
                            :animated="animate"
                            class="mb-2 w-75 "></b-progress>

                        <img src="https://i.imgur.com/ageVYAE.png" width="120px">
                            <img src="https://i.imgur.com/xJ8OMIG.gif" width="250px">
                                <b-progress
                                    height="30px"
                                    :value="30"
                                    variant="warning"
                                    striped="striped"
                                    :animated="animate"
                                    class="mb-2 w-75 "></b-progress>

                            </div>
                        </template>

                        <script>
                            export default {
                               mounted: {
                                  function() {
                                    $confetti
                                    .start()
                                  }
                               },
                                data() {
                                    return {animate, show: true}

                                },
                                methods: {
                                    start() {
                                        this
                                            .$confetti
                                            .start()
                                    }
                                }
                            }
                        </script>
                        <style>
                            .inline {
                                display: inline-block;
                            }
                        </style>