/** 
 * Constant for height of canvas
 * @type {number} 
 */
const HEIGHT = 544
/**
 * Constant for the measure of each cell
 * @type{number} 
 */
const MEDIDA = 32

/**
 * @author Miguel Hidalgo Castro
 * CLASS TORRE
 */
export class Torre {
    /**
     * Tower Constructor's
     * Create tower null
     */
    constructor() {
        this.x
        this.y
        this.width
        this.height
        this.isDragging
        this.radio
        this.vel
        this.lvl
        this.upg
        //cuando sea imagen será la ruta
        this.fill
        this.recogidos
        this.contadorTiempo
    }
    /**
     * Create especifications to tower lvl 1
     * @returns new Torre lvl 1
     */
    especificacionlvl1() {
        return {
            x: MEDIDA * 12,
            y: HEIGHT - 64,
            width: 32,
            height: 32,
            fill: "#AFDAFF",
            isDragging: false,
            radio: 100, 
            vel: 1,
            lvl: 1,
            upg: false,
            recogidos: 0,
            contadorTiempo: 0
        }
    }
    /**
         * Create especifications to tower lvl 2
         * @returns new Torre lvl 2
         */
    especificacionlvl2() {
        return {
            x: MEDIDA * 16,
            y: HEIGHT - 64,
            width: 32,
            height: 32,
            fill: "#ff550d",
            isDragging: false,
            radio: 150,
            vel: 2,
            lvl: 2,
            upg: false,
            recogidos: 0,
            contadorTiempo: 0
        }
    }
    /**
         * Create especifications to tower lvl 3
         * @returns new Torre lvl 3
         */
    especificacionlvl3() {
        return {
            x: MEDIDA * 20,
            y: HEIGHT - 64,
            width: 32,
            height: 32,
            fill: "#444444",
            isDragging: false,
            radio: 200,
            vel: 3,
            lvl: 3,
            upg: false,
            recogidos: 0,
            contadorTiempo: 0
        }
    }
    /**
     * Modified a tower with a new specification
     * @param {element} Tower with all params to create a new tower 
     */
    asignarEspecificacion({ x, y, width, height, isDragging, radio, vel, lvl, upg, fill, recogidos, contadorTiempo }) {
        this.x = x
        this.y = y
        this.width = width
        this.height = height
        this.isDragging = isDragging
        this.radio = radio
        this.vel = vel
        this.lvl = lvl
        this.upg = upg

        this.fill = fill
        this.recogidos = recogidos
        this.contadorTiempo = contadorTiempo
    }
}