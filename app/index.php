<html>
<head>
    <link rel="stylesheet" href="./assets/bootstrap.min.css">
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/bootstrap.min.js"></script>
    <script src="./assets/canvas.js"></script>
    <script src="./assets/cell.js"></script>
    <script>
        // server url 
        let server = "http://localhost:4000/server.php";
        $(document).ready(function () {
            // 
            function convertToCellObject(cells) {
                let length_y = cells.length,
                    length_x,
                    y, x;
                // each row
                for (y = 0; y < length_y; y++) {
                    length_x = init_cells[y].length;
                    // each column in rows
                    for (x = 0; x < length_x; x++) {
                        let state = (cells[y][x] == 1) ? 'alive' : 'dead';
                        cells[y][x] = new Cell(x, y, state);
                    }
                }

                return cells;
            };

            function toObject(arr) {
                let rv = {};
                for (let i = 0; i < arr.length; ++i)
                    rv[i] = arr[i];
                return rv;
            }

            let grid = [];
            let init_cells = init(); 
            grid = JSON.parse(JSON.stringify( init_cells ));

            let num_cells_y = init_cells.length,
                num_cells_x = init_cells[0].length,
                cell_width  = 10,
                cell_height = 10,
                canvas_id   = "grid", cell_array = [],
                display     = new Canvas(num_cells_x, num_cells_y, cell_width, cell_height, canvas_id);

            cell_array = convertToCellObject(init_cells);
            display.update(cell_array);

            run();
            $('#btn-run').click(function () {
                grid = [];
                loadPattern();
            });

            function run() {
                if ( Array.isArray(grid) )
                    setInterval(function () {
                        getNext(grid);
                    }, 200);
            }

            function loadPattern() {
                pattern = $("#pattern").val();
                $.ajax({
                    'url': server,
                    'type': 'POST',
                    'async': true,
                    'dataType': 'json',
                    'data': {pattern: pattern},
                    'success': function (nextGrid) {
                        grid = JSON.parse(JSON.stringify( nextGrid ));
                        cell_array = convertToCellObject(nextGrid);
                        display.update(cell_array);
                    },
                    'error': function (request, error) {
                        console.debug("Request: ", JSON.stringify(request));
                    }
                });
            }

            function getNext(gridData) {
                gridData =  JSON.stringify( gridData );
                pattern = $("#pattern").val();
                $.ajax({
                    'url': server,
                    'type': 'POST',
                    'async': true,
                    'dataType': 'json',
                    'data': {data: gridData, pattern: pattern},
                    'success': function (nextGrid) {
                        grid = JSON.parse(JSON.stringify( nextGrid ));
                        cell_array = convertToCellObject(nextGrid);
                        display.update(cell_array);
                    },
                    'error': function (request, error) {
                        console.debug("Request: ", JSON.stringify(request));
                    }
                });
            }

            function init() {
                // 
                let temp = null;
                $.ajax({
                    'url': server,
                    'type': 'GET',
                    'async': false,
                    'dataType': 'json',
                    'success': function (res) {
                        dataArr = JSON.parse(JSON.stringify( res )); 
                        temp = dataArr;
                    },
                    'error': function (request, error) {
                        console.debug("Request: ", JSON.stringify(request));
                    }
                });
                // console.table(init_cells); 
                return temp;
            }

        });
    </script>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Conway's Game of Life - PHP/Js</h3>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <form class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <select class="form-control" name="pattern" id="pattern">
                                <option value="random">Random</option>
                                <option value="exploder">Exploder</option>
                                <option value="glider">Glider</option>
                                <option value="glider_gun">Gosper Glider Gun</option>
                                <option value="lightweight_spaceship">Lightweight Spaceship</option>
                                <option value="tumbler">Tumbler</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" id="btn-run" class="btn btn-default">Run</button>
                </form>
            </div>
            <div class="col-md-6 col-md-offset-2">
                <canvas id="grid">
                    The browser not support! Try latest Google Chrome, Firefox, or Safari.
                </canvas>
            </div>
        </div>
    </div>

</body>
</html>