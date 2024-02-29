import React, { useState } from 'react';
import AddPostModal from './components/AddPostModal.tsx';

function App() {
  const [isModalOpen, setIsModalOpen] = useState(false);

  const handleOpenModal = () => {
    setIsModalOpen(true);
  };

  const handleCloseModal = () => {
    setIsModalOpen(false);
  };

  const handleSendPost = (author, content) => {
    console.log("Post was sended:");
    console.log("Author:", author);
    console.log("Content:", content);
  };

  return (
    <div className="App">
      <button onClick={handleOpenModal}>Open modal</button>
      <AddPostModal
        modalOpen={isModalOpen}
        handleSendPost={handleSendPost}
        handleCloseModal={handleCloseModal}
      />
    </div>
  );
}

export default App;
