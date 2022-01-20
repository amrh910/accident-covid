@extends('layouts.default')

@section('content')
    <style>
        
    </style>

    <div class="section">
        <div class="row">
            <div class="col-md-5 india">
                <div id="india-map"></div>
            </div>
            <div class="col-md-6 col-offset-1 cases">
                
                <div style="text-align: right;">
                    @isset($countries)
                    <select class="selectpicker" placeholder="Select Country" data-live-search="true">
                        @foreach($countries as $country)
                            @isset($country['iso2'])
                                <option value="{{ $country['iso2'] }}">{{ $country['name'] }}</option>
                            @endisset
                        @endforeach
                    </select>
                    @endisset
                    <button class="btn btn-add">Add</button>
                </div>
                
                <br>
                @isset($world)
                <div class="card main">
                    <p class="card-title">World</p>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card stat">
                                <div class="card-body stat">
                                    <p>{{ number_format($world['confirmed']) }}</p>
                                </div>
                                <div class="card-footer text-danger"><span>Active</span></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stat">
                                <div class="card-body stat">
                                    <p>{{ number_format($world['recovered']) }}</p>
                                </div>
                                <div class="card-footer text-success"><span>Recovered</span></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stat">
                                <div class="card-body stat">
                                    <p>{{ number_format($world['deaths']) }}</p>
                                </div>
                                <div class="card-footer text-warning"><span>Deceased</span></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stat">
                                <div class="card-body stat">
                                    <p>{{ number_format(intval($world['deaths']) + intval($world['recovered']) + intval($world['confirmed'])) }}</p>
                                </div>
                                <div class="card-footer"><span>Total</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endisset
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            mapInit();
        });
            // var election = new Datamap({
            //     scope: 'ind',
            //     element: document.getElementById('india-map')
            //     // geographyConfig: {
            //     //     highlightBorderColor: '#bada55',
            //     // popupTemplate: function(geography, data) {
            //     //     return '<div class="hoverinfo">' + geography.properties.name + 'Electoral Votes:' +  data.electoralVotes + ' '
            //     //     },
            //     //     highlightBorderWidth: 3
            // });

            // fills: {
            //     'Republican': '#CC4731',
            //     'Democrat': '#306596',
            //     'Heavy Democrat': '#667FAF',
            //     'Light Democrat': '#A9C0DE',
            //     'Heavy Republican': '#CA5E5B',
            //     'Light Republican': '#EAA9A8',
            //     defaultFill: '#EDDC4E'
            //     },
            //     data:{
            //     "AZ": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 5
            //     },
            //     "CO": {
            //         "fillKey": "Light Democrat",
            //         "electoralVotes": 5
            //     },
            //     "DE": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "FL": {
            //         "fillKey": "UNDECIDED",
            //         "electoralVotes": 29
            //     },
            //     "GA": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "HI": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "ID": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "IL": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "IN": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 11
            //     },
            //     "IA": {
            //         "fillKey": "Light Democrat",
            //         "electoralVotes": 11
            //     },
            //     "KS": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "KY": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "LA": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "MD": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "ME": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "MA": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "MN": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "MI": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "MS": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "MO": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 13
            //     },
            //     "MT": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "NC": {
            //         "fillKey": "Light Republican",
            //         "electoralVotes": 32
            //     },
            //     "NE": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "NV": {
            //         "fillKey": "Heavy Democrat",
            //         "electoralVotes": 32
            //     },
            //     "NH": {
            //         "fillKey": "Light Democrat",
            //         "electoralVotes": 32
            //     },
            //     "NJ": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "NY": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "ND": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "NM": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "OH": {
            //         "fillKey": "UNDECIDED",
            //         "electoralVotes": 32
            //     },
            //     "OK": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "OR": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "PA": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "RI": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "SC": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "SD": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "TN": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "TX": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "UT": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "WI": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "VA": {
            //         "fillKey": "Light Democrat",
            //         "electoralVotes": 32
            //     },
            //     "VT": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "WA": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "WV": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "WY": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "CA": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "CT": {
            //         "fillKey": "Democrat",
            //         "electoralVotes": 32
            //     },
            //     "AK": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "AR": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     },
            //     "AL": {
            //         "fillKey": "Republican",
            //         "electoralVotes": 32
            //     }
            //     }
            // });
            // election.labels();
        // });
    </script>
    
@endsection