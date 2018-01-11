var Cell = function(x, y, state) {
    return {
        x: x,
        y: y,
        state: state,
        getXPos: function() {
            return x;
        },
        getYPos: function() {
            return y;
        },
        getState: function() {
            return state;
        },
        setState: function(new_state) {
            state = new_state;
        },
        clone: function() {
            return new Cell(x, y, state);
        }
    };
};