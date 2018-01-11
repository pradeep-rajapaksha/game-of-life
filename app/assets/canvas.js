var Canvas = function (num_cells_x, num_cells_y, cell_width, cell_height, canvas_id) {
    var canvas = document.getElementById(canvas_id),
        ctx = canvas.getContext && canvas.getContext('2d'),
        width_pixels = num_cells_x * cell_width,
        height_pixels = num_cells_y * cell_height,
        drawGridLines = function () {
            ctx.lineWidth = 1;
            ctx.strokeStyle = "rgba(255, 0, 0, 1)";
            ctx.beginPath();
            // foreach column
            for (var i = 0; i <= num_cells_x; i++) {
                ctx.moveTo(i * cell_width, 0);
                ctx.lineTo(i * cell_width, height_pixels);
            }
            // foreach row
            for (var j = 0; j <= num_cells_y; j++) {
                ctx.moveTo(0, j * cell_height);
                ctx.lineTo(width_pixels, j * cell_height);
            }
            ctx.stroke();
        },
        updateCells = function (cell_array) {
            // console.log('mad_msg__cell_array',cell_array)
            var length_y = cell_array.length,
                length_x,
                y, x;
            // each row
            for (y = 0; y < length_y; y++) {
                length_x = cell_array[y].length;
                // each column in rows
                for (x = 0; x < length_x; x++) {
                    // Draw Cell on Canvas
                    drawCell(cell_array[y][x]);
                }
            }
        },
        drawCell = function (cell) {
            // find start point (top left)
            var start_x = cell.getXPos() * cell_width,
                start_y = cell.getYPos() * cell_height;
            // draw rect from that point, to bottom right point by adding cell_height/cell_width
            if (cell.getState() == "alive") {

                ctx.fillRect(start_x, start_y, cell_width, cell_height);
            } else {
                ctx.clearRect(start_x, start_y, cell_width, cell_height);
            }
        },
        init = function () {
            // Resize Canvas
            canvas.width = width_pixels;
            canvas.height = height_pixels;

            // No grid lines, for now!
            drawGridLines();
        };
    init();
    return {
        update: function (cell_array) {
            updateCells(cell_array);
        }
    };


};