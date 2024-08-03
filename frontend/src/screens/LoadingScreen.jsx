import { Center, Spinner } from '@chakra-ui/react'
function LoadingScreen() {
  return (
    <Center w='100vw' h='100vh' p={3}>
      <Spinner size='xl'></Spinner>
    </Center>
  )
}
export default LoadingScreen
