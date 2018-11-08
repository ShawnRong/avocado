export function isValidUsername(str) {
  const validMap = ['admin', 'editor', 'admin@test.com'];
  return validMap.indexOf(str.trim()) >= 0;
}
