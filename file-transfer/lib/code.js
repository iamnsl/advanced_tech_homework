// Alphabet avoids visually-confusable characters (0/O, 1/I).
const ALPHABET = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
const CODE_LENGTH = 6;
export const CODE_PATTERN = /^[A-Z0-9]{6}$/;

export function randomCode(length = CODE_LENGTH) {
  const bytes = new Uint32Array(length);
  crypto.getRandomValues(bytes);
  let code = "";
  for (let i = 0; i < length; i++) {
    code += ALPHABET[bytes[i] % ALPHABET.length];
  }
  return code;
}

export function normalizeCode(code) {
  return (code || "").trim().toUpperCase();
}
