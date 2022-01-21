@extends('layouts.default')

@section('content')
    <div class="section">
        <p class="heading-text">Welcome {{ Auth::user()->name }}</p>
        <div class="row">
            <div class="col-md-5 india">
                <div id="india-map"></div>
            </div>
            <div class="col-md-6 col-offset-1 cases">
                
                <div style="text-align: right;">
                    @isset($countries)
                    <select class="selectpicker" placeholder="Select Country" id="country-select" data-live-search="true">
                        @foreach($countries as $country)
                            @isset($country['iso2'])
                                <option value="{{ $country['iso2'] }}">{{ $country['name'] }}</option>
                            @endisset
                        @endforeach
                    </select>
                    @endisset
                    <button onclick="getCountry();" class="btn btn-add">Add</button>
                </div>
                
                <br>
                <div id="countries-container">
                    @isset($world)
                    <div class="card main">
                        <p class="card-title">World</p>
                        <div class="row">
                            <div class="col-md-3 confirmed">
                                <div class="card stat">
                                    <div class="card-body stat">
                                        <p>{{ number_format($world['confirmed']) }}</p>
                                    </div>
                                    <div class="card-footer text-danger"><span>Active</span></div>
                                </div>
                            </div>
                            <div class="col-md-3 recovered">
                                <div class="card stat">
                                    <div class="card-body stat">
                                        <p>{{ number_format($world['recovered']) }}</p>
                                    </div>
                                    <div class="card-footer text-success"><span>Recovered</span></div>
                                </div>
                            </div>
                            <div class="col-md-3 dead">
                                <div class="card stat">
                                    <div class="card-body stat">
                                        <p>{{ number_format($world['deaths']) }}</p>
                                    </div>
                                    <div class="card-footer text-warning"><span>Deceased</span></div>
                                </div>
                            </div>
                            <div class="col-md-3 total">
                                <div class="card stat">
                                    <div class="card-body stat">
                                        <p>{{ number_format(intval($world['deaths']) + intval($world['recovered']) + intval($world['confirmed'])) }}</p>
                                    </div>
                                    <div class="card-footer"><span>Total</span></div>
                                </div>
                            </div>
                            {{-- <span class="text-danger remove" onclick="removePref(this, `{{ $dash['code'] }}`);">remove</span> --}}
                        </div>
                    </div>
                    @endisset
                    @isset($dashboard)
                        @foreach($dashboard as $dash)
                            <div class="card main">
                                <p class="card-title">{{ $dash['country'] }}</p>
                                <div class="row">
                                    <div class="col-md-3 confirmed">
                                        <div class="card stat">
                                            <div class="card-body stat">
                                                <p>{{ number_format($dash['confirmed']) }}</p>
                                            </div>
                                            <div class="card-footer text-danger"><span>Active</span></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 recovered">
                                        <div class="card stat">
                                            <div class="card-body stat">
                                                <p>{{ number_format($dash['recovered']) }}</p>
                                            </div>
                                            <div class="card-footer text-success"><span>Recovered</span></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 dead">
                                        <div class="card stat">
                                            <div class="card-body stat">
                                                <p>{{ number_format($dash['deaths']) }}</p>
                                            </div>
                                            <div class="card-footer text-warning"><span>Deceased</span></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 total">
                                        <div class="card stat">
                                            <div class="card-body stat">
                                                <p>{{ number_format(intval($dash['deaths']) + intval($dash['recovered']) + intval($dash['confirmed'])) }}</p>
                                            </div>
                                            <div class="card-footer"><span>Total</span></div>
                                        </div>
                                    </div>
                                    <span class="text-danger remove" onclick="removePref(this, `{{ $dash['code'] }}`);">remove</span>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            var map = new Datamap({
                element: document.getElementById('india-map'),
                scope: 'india',
                responsive: true,
                fills: {
                    'MAJOR': '#306596',
                    'MEDIUM': '#0fa0fa',
                    'MINOR': '#bada55',
                    defaultFill: '#dddddd'
                },
                data: {
                    @php
                        foreach($mapdata as $key=>$data)
                        {
                            if($key != array_key_last($mapdata))
                            {
                                echo "'". $key ."'" .': { deceased: ' . $data["deceased"] . ', confirmed: '. $data["confirmed"]. ', recovered: '. $data["recovered"].' },'."\n";
                            }
                            else
                            {
                                echo "'" .$key ."'" . ': { deceased: ' . $data["deceased"] . ', confirmed: '. $data["confirmed"]. ', recovered: '. $data["recovered"].' }'."\n";
                            }
                        }
                    @endphp
                },
                geographyConfig: {
                    popupOnHover: true,
                    highlightOnHover: true,
                    borderColor: '#444',
                    borderWidth: 0.5,
                    dataUrl: 'https://rawgit.com/Anujarya300/bubble_maps/master/data/geography-data/india.topo.json',
                    popupTemplate: function(geo, data) {
                        return ['<div class="hoverinfo"><strong>',
                                '' + geo.properties.name,
                                '</strong><br> confirmed: ' + data.confirmed,
                                '<br> recovered: ' + data.recovered,
                                '<br> deceased: ' + data.deceased,
                                '</strong></div>'].join('');
                    }
                    //dataJson: topoJsonData
                },
                setProjection: function (element) {
                    var projection = d3.geo.mercator()
                        .center([80, 25]) // always in [East Latitude, North Longitude]
                        .scale(800)
                        .translate([element.offsetWidth / 2, element.offsetHeight / 2]);
                    var path = d3.geo.path().projection(projection);
                    return { path: path, projection: projection };
                }
            });
            $(window).on('resize', function() {
                map.resize();
            });
        });

        function getCountry() {
            var country = $('#country-select').val();
            var name = $('#country-select option:selected').text();
            if(country != '')
            {
                $.ajax({
                    url: "/get-data",
                    type:"POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        country: country,
                        name: name
                    },
                    success:function(response){
                        let total = parseInt(response.confirmed) + parseInt(response.deaths) + parseInt(response.recovered);
                        let clone = $('#countries-container').children(':last').clone();
                        $(clone).children('.card-title').text(response.country);
                        $(clone).children('.row').children('.confirmed').children('.card').children('.card-body').children('p').text(response.confirmed);
                        $(clone).children('.row').children('.recovered').children('.card').children('.card-body').children('p').text(response.recovered);
                        $(clone).children('.row').children('.dead').children('.card').children('.card-body').children('p').text(response.deaths);
                        $(clone).children('.row').children('.total').children('.card').children('.card-body').children('p').text(total);
                        $('#countries-container').append(clone);
                    }
                });
            }
            else
            {
                alert('You have to select a country');
            }
        }

        function removePref(ele, code) {
            var parent = $(ele).parent().parent();
            $.ajax({
                url: "/remove",
                type:"POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    country: code
                },
                success:function(response){
                    $(parent).remove();
                }
            });
        }

        
        
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