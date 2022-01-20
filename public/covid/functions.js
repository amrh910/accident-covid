// $('input.form-control').keydown(function() {
//     $(this).addClass('key');
// });
// $('input.form-control').keyup(function() {
//     $(this).removeClass('key');
// });

function registerValide()
{
    if($('#password').val() != $('#confirm-password').val())
    {
        $('#no-match').show();
    }
    else
    {
        $('#register').submit();
    }
}

function mapInit()
{
    var map = new Datamap({
                element: document.getElementById('india-map'),
                scope: 'india',
                responsive: true,
                geographyConfig: {
                    popupOnHover: true,
                    highlightOnHover: true,
                    borderColor: '#444',
                    borderWidth: 0.5,
                    dataUrl: 'https://rawgit.com/Anujarya300/bubble_maps/master/data/geography-data/india.topo.json'
                    //dataJson: topoJsonData
                },
                fills: {
                    'MAJOR': '#306596',
                    'MEDIUM': '#0fa0fa',
                    'MINOR': '#bada55',
                    defaultFill: '#dddddd'
                },
                data: {
                    'JH': { fillKey: 'MINOR' },
                    'MH': { fillKey: 'MINOR' }
                },
                setProjection: function (element) {
                    var projection = d3.geo.mercator()
                        .center([80, 25]) // always in [East Latitude, North Longitude]
                        .scale(850)
                        .translate([element.offsetWidth / 2, element.offsetHeight / 2]);
                    var path = d3.geo.path().projection(projection);
                    return { path: path, projection: projection };
                }
            });
            $(window).on('resize', function() {
                map.resize();
            });
}