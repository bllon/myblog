/**
 * 加密
 */
import { sha256 } from 'js-sha256'

export function encrypt(str) {
    return sha256(str)
}